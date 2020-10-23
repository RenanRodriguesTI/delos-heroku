<?php

    namespace Delos\Dgp\Http\Controllers;

    use Delos\Dgp\Entities\HotelRoom;
    use Delos\Dgp\Repositories\Contracts\AirportRepository;
    use Delos\Dgp\Repositories\Contracts\CarTypeRepository;
    use Delos\Dgp\Repositories\Contracts\ProjectRepository;
    use Delos\Dgp\Repositories\Contracts\StateRepository;
    use Delos\Dgp\Repositories\Contracts\UserRepository;
    use Delos\Dgp\Repositories\Criterias\Project\ProjectLeaderCriteria;

    /**
     * Class RequestsController
     * @package Delos\Dgp\Http\Controllers
     */
    class RequestsController extends AbstractController
    {
        /**
         * @return array
         */
        protected function getVariablesForCreateView(): array
        {
            app(ProjectRepository::class)->pushCriteria(ProjectLeaderCriteria::class);
            return [
                'carTypes'   => app(CarTypeRepository::class)->orderBy('name', 'asc')->pluck('name', 'id'),
                'users'      => app(UserRepository::class)->orderBy('name', 'asc')->pluck('name', 'id'),
                'airports'   => app(AirportRepository::class)->all(),
                'states'     => app(StateRepository::class)->pluck('name', 'id'),
                'hotelRooms' => app(HotelRoom::class)->orderBy('id')->pluck('name', 'id')
            ];
        }


        public function index(){

            if($this->request->wantsJson()){
                return $this->response->json(['data'=>app(ProjectRepository::class)
                ->getPairsForRequests(false)]);
            }
            return parent::index();
        }

        /**
         * @return array
         */
        protected function getVariablesForIndexView(): array
        {
            return [
                'projects'   => app(ProjectRepository::class)->getPairs(),
                'users'      => app(UserRepository::class)->getPairs()
            ];
        }

        /**
         * @param int $id
         *
         * @return \Illuminate\Http\RedirectResponse
         */
        public function approve(int $id)
        {
            $this->service->approve($id);
            return $this->response->redirectToRoute('requests.index',$this->request->all());
        }

        /**
         * @param int $id
         *
         * @return \Illuminate\Http\RedirectResponse
         */
        public function refuse(int $id)
        {
            $reason = $this->request->input('reason');
            $this->service->refuse($id, $reason);
            return $this->response->redirectToRoute('requests.index',$this->request->all());
        }
    }
