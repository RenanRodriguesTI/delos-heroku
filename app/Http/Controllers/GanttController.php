<?php

    namespace Delos\Dgp\Http\Controllers;

    use Delos\Dgp\Repositories\Contracts\ProjectRepository;
    use Delos\Dgp\Repositories\Contracts\UserRepository;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Http\Request;

    /**
     * Class GanttController
     * @package Delos\Dgp\Http\Controllers
     */
    class GanttController extends Controller
    {
        /**
         * @var Request
         */
        private $request;
        /**
         * @var ProjectRepository
         */
        private $projectRepository;
        /**
         * @var UserRepository
         */
        private $userRepository;

        /**
         * GanttController constructor.
         *
         * @param Request           $request
         * @param ProjectRepository $projectRepository
         * @param UserRepository    $userRepository
         */
        public function __construct(Request $request, ProjectRepository $projectRepository, UserRepository $userRepository)
        {
            $this->request           = $request;
            $this->projectRepository = $projectRepository;
            $this->userRepository    = $userRepository;
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function indexResources()
        {
            $collaborators = $this->userRepository->pluck('name', 'id');
            $users         = $this->getUsersToGantt();

            return view('reports.ganttResources', compact('users', 'collaborators'));
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function indexProjects()
        {
            $projectsToSearch = $this->projectRepository->withTrashed()
                                                        ->pluck('full_description', 'id');
            $projects         = $this->getProjectsToGantt();

            return view('reports.ganttProjects', compact('projects', 'projectsToSearch'));
        }

        /**
         * Get gantt content of projects
         * @return mixed
         */
        private function getProjectsToGantt()
        {
            $projects = $this->projectRepository->makeModel()
                                                ->with('activities', 'activities.user', 'activities.task')
                                                ->has('activities')
                                                ->withTrashed()
                                                ->orderBy('id', 'desc')
                                                ->paginate(20);

            $searchableProjects = $this->request->get('projects');

            if ( $searchableProjects ) {
                $projects = $this->projectRepository->withTrashed()
                                                    ->orderBy('id', 'desc')
                                                    ->findWhereIn('id', $searchableProjects);
            }
            return $projects;
        }

        /**
         * Get gantt content of users
         * @return mixed
         */
        private function getUsersToGantt()
        {
            $users           = $this->userRepository->makeModel()
                                                    ->with('allocations', 'allocations.project', 'allocations.task')
                                                    ->has('allocations', '>', 0)
                                                    ->withTrashed()
                                                    ->orderBy('id', 'desc')
                                                    ->paginate(20);
            $searchableUsers = $this->request->get('collaborators');
            if ( $searchableUsers ) {
                $users = $this->userRepository->with('allocations', 'allocations.project', 'allocations.task')
                                              ->has('allocations', '>', 0)
                                              ->withTrashed()
                                              ->orderBy('id', 'desc')
                                              ->findWhereIn('id', $searchableUsers);
            }
            return $users;
        }
    }
