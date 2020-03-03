<?php

    namespace Delos\Dgp\Services;

    use Carbon\Carbon;
    use Delos\Dgp\Repositories\Contracts\UserRepository;
    use Delos\Dgp\Repositories\Eloquent\CoastUserRepositoryEloquent;
    use Illuminate\Database\ConnectionInterface as Connection;
    use Illuminate\Events\Dispatcher as Event;
    use Prettus\Validator\Contracts\ValidatorInterface;

    /**
     * Class ActivityService
     * @package Delos\Dgp\Services
     */
    class CoastUserService extends AbstractService
    {
        /**
         * @var UserRepository
         */
        private $userRepository;

        /**
         * CoastUserService constructor.
         *
         * @param ValidatorInterface $validator
         * @param Event              $event
         * @param Connection         $conn
         * @param UserRepository     $userRepository
         */
        public function __construct(ValidatorInterface $validator, Event $event, Connection $conn, UserRepository $userRepository)
        {
            parent::__construct($validator, $event, $conn);
            $this->userRepository = $userRepository;
        }

        /**
         * @return string
         */
        public function repositoryClass(): string
        {
            return CoastUserRepositoryEloquent::class;
        }

        /**
         * @param array $data
         * @param       $id
         *
         * @return mixed
         * @throws \Prettus\Validator\Exceptions\ValidatorException
         */
        public function update(array $data, $id)
        {
            $user         = $this->userRepository->withTrashed()->find($id);
            $data['date'] = (new Carbon("First Day of {$data['date']} {$data['year']}"));

            $this->excludeAllCoastsWhereMonthAndYear($data, $user);

            return $this->create($data);
        }

        public function copyLastValues()
        {
            $users = $this->getAllUsersWithCoasts();

            foreach ( $users as $user ) {
                $lastCoast = $this->getLastCoast($user);

                if ( $lastCoast && !$this->isSameMonth($lastCoast) ) {
                    $availableYears = (now()->year - $lastCoast->date->year);

                    for ( $i = $availableYears; $i >= 0; $i-- ) {
                        $year  = now()->year - $i;
                        $month = $year == now()->year ? Carbon::now()->month : 12;

                        for ( $j = 1; $j <= $month; $j++ ) {
                            $date  = Carbon::createFromFormat('d/m/Y', "1/{$j}/{$year}");
                            $coast = $user->coasts();

                            if ( $this->getCoastFromDate($coast, $date) == 0 ) {
                                $coast->create([
                                                   'date'  => $date,
                                                   'value' => $lastCoast->value
                                               ]);
                            }
                        }

                    }
                }
            }

            return $users;
        }

        /**
         * @param array $data
         * @param       $user
         */
        private function excludeAllCoastsWhereMonthAndYear(array $data, $user): void
        {
            $user->coasts()
                 ->where(\DB::raw('year(date)'), $data['year'])
                 ->where(\DB::raw('monthname(date)'), 'like', $data['date']->format('F'))
                 ->get()
                 ->each(function ($item, $key) {
                     return $item->delete();
                 });
        }

        /**
         * @param $lastCoast
         *
         * @return bool
         */
        private function isSameMonth($lastCoast): bool
        {
            $month = Carbon::now()->month;
            return $lastCoast->date->month == $month;
        }

        /**
         * @param $user
         *
         * @return mixed
         */
        private function getLastCoast($user)
        {
            $lastCoast = $user->coasts()
                              ->get()
                              ->last();

            return $lastCoast;
        }

        /**
         * @return mixed
         */
        private function getAllUsersWithCoasts()
        {
            $users = app(UserRepository::class)
                ->with('coasts')
                ->withTrashed()
                ->all();
            return $users;
        }

        /**
         * @param $coast
         * @param $date
         *
         * @return mixed
         */
        private function getCoastFromDate($coast, $date)
        {
            return $coast->where('date', $date->format('Y-m-d'))
                         ->get()
                         ->count();
        }
    }