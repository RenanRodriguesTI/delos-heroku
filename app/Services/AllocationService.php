<?php
    /**
     * Created by PhpStorm.
     * User: allan
     * Date: 18/04/18
     * Time: 11:46
     */

    namespace Delos\Dgp\Services;

    use Carbon\Carbon;
    use Delos\Dgp\Entities\Allocation;
    use Delos\Dgp\Events\DeletedAllocation;
    use Delos\Dgp\Events\SavedAllocation;
    use Delos\Dgp\Repositories\Contracts\ProjectRepository;
    use Delos\Dgp\Repositories\Eloquent\AllocationRepositoryEloquent;
    use Prettus\Validator\Contracts\ValidatorInterface;

    /**
     * Class AllocationService
     * @package Delos\Dgp\Services
     */
    class AllocationService extends AbstractService
    {
        use WorkingDay, RangeTrait;

        /**
         * @param array $data
         *
         * @return mixed
         * @throws \Prettus\Validator\Exceptions\ValidatorException
         */
        public function create(array $data)
        {
            $this->addValidationToDates($data);
            $this->addValidationToHours($data);

            $data['group_company_id'] = \Auth::user()->groupCompany->id;

            $this->validator->with($data)
                            ->passesOrFail(ValidatorInterface::RULE_CREATE);

            $allocationFather  = $this->repository->create($data);
            $allocations       = collect();
            $data['parent_id'] = $allocationFather->id;

            \DB::transaction(function () use ($data, $allocations) {
                $diffInDays    = $this->getDateRange($data['start'], $data['finish']);
                $data['hours'] = $data['hours'] / $this->countWorkDays($data);


                foreach ( $diffInDays as $day ) {
                    $data['start']  = $day->format('d/m/Y');
                    $data['finish'] = $day->format('d/m/Y');

                    if ( $this->isWorkingDay($day) ) {
                        $allocation = $this->repository->create($data);
                        $allocations->push($allocation);
                    }
                }
            });
            $this->fireEvent($data);

            return $allocations;
        }

        /**
         * @param array $data
         */
        private function addValidationToDates(array $data): void
        {
            $project = app(ProjectRepository::class)->find($data['project_id']);
            $rules   = $this->validator->getRules();

            $rules['create']['start']  .= '|after_or_equal:' . $project->start->format('d/m/Y');
            $rules['update']['start']  .= '|after_or_equal:' . $project->start->format('d/m/Y');
            $rules['create']['finish'] .= '|before_or_equal:' . $project->finish->format('d/m/Y');
            $rules['update']['finish'] .= '|before_or_equal:' . $project->finish->format('d/m/Y');

            $this->validator->setRules($rules);
        }

        /**
         * Add max quantity hours according with period
         *
         * @param $data
         */
        private function addValidationToHours($data): void
        {
            $actualHours = $this->getActualHours($data);
            $rules       = $this->validator->getRules();
            $max         = iterator_count($this->getDateRange($data['start'], $data['finish'])) * 24 - $actualHours;

            $rules['create']['hours'] .= '|max:' . $max;
            $rules['update']['hours'] .= '|max:' . $max;

            $this->validator->setRules($rules);
        }

        /**
         * @param $data
         *
         * @return mixed
         */
        private function getActualHours($data)
        {
            $start       = Carbon::createFromFormat('d/m/Y', $data['start']);
            $finish      = Carbon::createFromFormat('d/m/Y', $data['finish']);
            $actualHours = $this->repository->findWhere([
                                                            ['start', '>=', $start->format('Y-m-d')],
                                                            ['finish', '<=', $finish->format('Y-m-d')],
                                                            'user_id' => $data['user_id']
                                                        ])
                                            ->sum('hours');

            return $actualHours;
        }

        /**
         * @param array $data
         *
         * @return int
         */
        private function countWorkDays(array $data): int
        {
            $quantity   = 0;
            $diffInDays = $this->getDateRange($data['start'], $data['finish']);

            foreach ( $diffInDays as $day ) {
                if ( $this->isWorkingDay($day) ) {
                    $quantity++;
                }
            }
            return $quantity;
        }

        /**
         * @param array $data
         */
        private function fireEvent(array $data)
        {
            $allocation = new Allocation($data);
            $this->event->fire(new SavedAllocation($allocation));
        }

        /**
         * @param $id
         *
         * @return int
         */
        public function delete($id)
        {
            $allocation = $this->repository->find($id);
            $deleted    = $this->repository->makeModel()
                                           ->find($id)
                                           ->forceDelete();
            $this->event->fire(new DeletedAllocation($allocation));
            return $deleted;
        }

        /**
         * @return string
         */
        public function repositoryClass(): string
        {
            return AllocationRepositoryEloquent::class;
        }
    }