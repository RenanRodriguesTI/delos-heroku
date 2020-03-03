<?php

    namespace Delos\Dgp\Http\Controllers;

    use Delos\Dgp\Http\Middleware\Authorize;
    use Delos\Dgp\Reports\PerformanceQueries;
    use Delos\Dgp\Repositories\Contracts\UserRepository;

    /**
     * Class ReportsController
     * @package Delos\Dgp\Http\Controllers
     */
    class ReportsController extends Controller
    {
        use AuthorizeTrait;

        /**
         * @var UserRepository
         */
        private $userRepository;
        /**
         * @var PerformanceQueries
         */
        private $performanceQueries;

        /**
         *
         */
        public const MONTHS = [
            1  => 'Janeiro',
            2  => 'Fevereiro',
            3  => 'Março',
            4  => 'Abril',
            5  => 'Maio',
            6  => 'Junho',
            7  => 'Julho',
            8  => 'Agosto',
            9  => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro'
        ];

        /**
         * ReportsController constructor.
         *
         * @param UserRepository     $userRepository
         * @param PerformanceQueries $performanceQueries
         */
        public function __construct(UserRepository $userRepository, PerformanceQueries $performanceQueries)
        {
            $this->middleware(Authorize::class);
            $this->userRepository     = $userRepository;
            $this->performanceQueries = $performanceQueries;
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function ownersIndex()
        {
            $owners                 = $this->performanceQueries->getOwnersReport();
            $owners->isDownloadable = true;
            $months                 = self::MONTHS;
            $collaborators          = $this->userRepository->getPairs();
            return view('reports.owners', compact('owners', 'months', 'collaborators'));
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function usersIndex()
        {
            $users                 = $this->convertToArray([
                                                               'name',
                                                               'total_projects',
                                                               'total_right_projects',
                                                               'total_wrong_projects'
                                                           ], $this->performanceQueries->getUsersReport());
            $users->isDownloadable = true;
            $months                = self::MONTHS;
            $collaborators         = $this->userRepository->all(['name']);

            return view('reports.users', compact('users', 'months', 'collaborators'));
        }

        /**
         * @param array $structure
         * @param       $collection
         *
         * @return mixed
         */
        private function convertToArray(array $structure, $collection)
        {
            return $collection->transform(function ($item) use ($structure) {
                $result = [];

                foreach ( $structure as $name ) {
                    $result[$name] = $item->$name;
                }

                return $result;
            });
        }
    }
