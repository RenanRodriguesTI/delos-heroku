<?php

    namespace Delos\Dgp\Repositories\Eloquent;

    use Carbon\Carbon;
    use Delos\Dgp\Entities\Project;
    use Delos\Dgp\Presenters\ProjectPresenter;
    use Delos\Dgp\Repositories\Contracts\ProjectRepository;
    use Delos\Dgp\Repositories\Criterias\Project\ScopeCriteria;
    use Delos\Dgp\Entities\ProjectProposalValue;

    /**
     * Class ProjectRepositoryEloquent
     * @package Delos\Dgp\Repositories\Eloquent
     */
    class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository
    {
        /**
         * @var array
         */
        protected $fieldSearchable = [
            'compiled_cod'     => 'like',
            'description'      => 'like',
            'owner.name'       => 'like',
        ];

        /**
         * @throws \Prettus\Repository\Exceptions\RepositoryException
         */
        public function boot()
        {
            parent::boot();
            $this->pushCriteria(ScopeCriteria::class);
        }

        /**
         * @return string
         */
        public function model()
        {
            return Project::class;
        }

        /**
         * @return string
         */
        public function presenter()
        {
            return ProjectPresenter::class;
        }

        /**
         * @param bool $applyWithTrashed
         *
         * @return array
         */
        public function getPairs($applyWithTrashed = true): array
        {
            $projects = $this;

            if ($applyWithTrashed) {
                $projects = $projects->withTrashed();
            }

            $projects = $projects->all();
            $projects->transform(function ($project) {
                return [
                    'id'          => $project->id,
                    'description' => $project->full_description
                ];
            });

            return $projects->pluck('description', 'id')->toArray();
        }

        /**
         * @return array
         */
        public function getPairsDisabled(): array
        {
            $projects = $this->getAllSoftDelete(false);

            $projects->transform(function ($project) {
                return [
                    'id'          => $project->id,
                    'description' => $project->full_description
                ];
            });

            return $projects->pluck('description', 'id')->toArray();
        }

        /**
         * @param array $membersIds
         * @param int   $projectId
         */
        public function attachMembers(array $membersIds, int $projectId): void
        {
            $this->find($projectId)->members()->attach($membersIds);
        }

        /**
         * @param int $memberId
         * @param int $projectId
         */
        public function detachMember(int $memberId, int $projectId): void
        {
            $this->find($projectId)->members()->detach($memberId);
        }

        /**
         * @param int $year
         *
         * @return string
         */
        private function getStartOfYear(int $year)
        {
            $dateString = Carbon::createFromFormat('Y', $year)->startOfYear()->toDateString();

            return $dateString;
        }

        /**
         * @param int $year
         *
         * @return string
         */
        private function getEndOfYear(int $year)
        {
            $dateString = Carbon::createFromFormat('Y', $year)->endOfYear()->toDateString();

            return $dateString;
        }

        /**
         * @param int    $clientId
         * @param Carbon $year
         *
         * @return string
         */
        public function getLastClientCodeByClientIdAndYear(int $clientId, Carbon $year): string
        {
            $periodOfOneYear = [
                $this->getStartOfYear($year->format('Y')),
                $this->getEndOfYear($year->format('Y'))
            ];

            $model = $this->model->newQueryWithoutScopes();

            $model = $model->has('clients', '=', 1)->whereHas('clients', function ($query) use ($clientId) {
                    $query->where('client_id', $clientId);
                })->whereBetween('start', $periodOfOneYear);

            $cod = $model->max('cod');

            return $cod ?? '00';
        }

        /**
         * @param int    $groupId
         * @param Carbon $year
         *
         * @return string
         */
        public function getLastGroupCodeByGroupIdAndYear(int $groupId, Carbon $year): string
        {
            $periodOfOneYear = [
                $this->getStartOfYear($year->format('Y')),
                $this->getEndOfYear($year->format('Y'))
            ];

            $model = $this->model->newQueryWithoutScopes();

            $model = $model->whereBetween('start', $periodOfOneYear)->has('clients', '>', 1)->whereHas('clients.group', function ($query) use ($groupId) {
                    $query->where('id', $groupId);
                });

            $cod = $model->max('cod');
            return $cod ?? '00';
        }

        /**
         * @param Carbon $date
         *
         * @return iterable
         */
        public function getPairsByDate(Carbon $date): iterable
        {
            $this->applyCriteria();
            $this->applyScope();

            $projects = $this->model->whereRaw("'{$date->toDateString()}' BETWEEN start and finish")->get();

            $transformed = $projects->transform(function ($project) {

                return [
                    'id'          => $project->id . ' - project',
                    'description' => "Nº: $project->compiled_cod - De: {$project->start->format('d/m/Y')} - Até: {$project->finish->format('d/m/Y')} * Descrição do projeto: {$project->description}"
                ];
            });

            return $transformed->pluck('description', 'id');
        }

        public function getAvaliableProposalValues(int $id, $proposalValuesDescriptionId = null){
            $project = $this->find($id);
            $sumProposalValue = $project->proposal_value - $project->proposalValueDescriptions->sum("value");

            if ($proposalValuesDescriptionId) {
                $sumProposalValue += ProjectProposalValue::find($proposalValuesDescriptionId)->value;
            }

            return $sumProposalValue;
        }
    }