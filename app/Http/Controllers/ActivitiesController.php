<?php

    namespace Delos\Dgp\Http\Controllers;
    use Delos\Dgp\Entities\Project;
    use Delos\Dgp\Entities\Activity;
    use Delos\Dgp\Events\DeleteActivityEvent;
    use Delos\Dgp\Repositories\Contracts\{PlaceRepository, ProjectRepository, TaskRepository};
    use Delos\Dgp\Repositories\Contracts\UserRepository;
    use Delos\Dgp\Repositories\Criterias\Activity\FilterCriteria;
    use Delos\Dgp\Repositories\Eloquent\PlaceRepositoryEloquent;
    use Delos\Dgp\Repositories\Eloquent\ProjectRepositoryEloquent;
    use Illuminate\Support\Facades\DB;
    use PDF;

    class ActivitiesController extends AbstractController
    {
        protected function getRequestDataForStoring(): array
        {
            $data                             = $this->request->all();
            $data['include_non_working_days'] = $this->request->has('include_non_working_days');
            return $data;
        }

        protected function getVariablesForCreateView(): array
        {
            $projects = $this->getProjectRepository()
                             ->getPairsByExtension(false);
            $places = $this->getPlaceRepository()
                ->pluck('name', 'id');

            return compact('projects', 'places');
        }

        protected function getVariablesForIndexView(): array
        {
            $users    = app(UserRepository::class)->pluck('name', 'id');
            $projects = $this->getProjectRepository()
                             ->getPairs();
            $tasks    = app(TaskRepository::class)->pluck('name', 'id');

            return compact('users', 'projects', 'tasks');
        }

        public function index()
        {
            if($this->request->wantsJson()){
                return $this->response->json($this->getProjectRepository()
                ->getPairsByExtension(false));
            }
            $this->repository->pushCriteria(new FilterCriteria());
            $this->repository->orderBy('date', 'desc');
            return parent::index();
        }

        public function destroy(int $id)
        {
            DB::beginTransaction();
            $activity = Activity::query()
                ->withoutGlobalScopes()
                ->findOrFail($id);

            $originalModel = clone $activity;
            $activity->forceDelete();

            event(new DeleteActivityEvent($originalModel));
            DB::commit();

            return redirect($this->getInitialUrlIndex())
                ->with('success', $this->getMessage('deleted'));
        }

        public function approve($id)
        {
            $this->service->approve($id);
            return $this->response->redirectToRoute($this->getRouteAliasForIndexAction());
        }

        public function externalWorksReport()
        {
            $activities = $this->repository->getExternalWorksLastMonthForListing();
            $filename   = resource_path("views/{$this->getViewNamespace()}/external-activities.xlsx");

            $this->download($activities, $filename);
        }

        public function downloadReport(int $id)
        {
            $data = [
                'activity' => $this->repository->find($id)
            ];

            $pdf = PDF::loadView('activities.report', $data);
            return $pdf->download('activity.pdf');
        }

        private function getProjectRepository(): ProjectRepositoryEloquent
        {
            return app(ProjectRepository::class);
        }

        private function getPlaceRepository(): PlaceRepositoryEloquent
        {
            return app(PlaceRepository::class);
        }
    }
