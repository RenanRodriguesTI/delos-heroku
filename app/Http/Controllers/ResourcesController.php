<?php

namespace Delos\Dgp\Http\Controllers;

use Delos\Dgp\Repositories\Contracts\UserRepository;
use Delos\Dgp\Repositories\Criterias\LoggedUserMembersCriteria;
use Delos\Dgp\Repositories\Criterias\User\ResourceCriteria;
use Carbon\Carbon;
use Prettus\Validator\Exceptions\ValidatorException;
use Delos\Dgp\Entities\User;
class ResourcesController extends AbstractController
{
    public function index()
    {
        $this->authorize('is-partner-business-or-root',User::class);
        $users = app(UserRepository::class)->popCriteria(LoggedUserMembersCriteria::class)
        ->pushCriteria(ResourceCriteria::class)->paginate(10);
        return view('resources.index',compact('users'));
    }

    public function show(int $id)
    {
        try {

            $this->request->validate([
                'start' => 'required|date_format:d/m/Y',
                'finish' => 'required|date_format:d/m/Y'
            ]);
            $resource = $this->service->resource($id,$this->request->all());

            return $this->response->json($resource,count( $resource) >0 ? 200 : 404);
        } catch (ValidatorException $e) {
            return $this->response->json($e->getMessageBag(), 422);
        }
    }


    public function situation(int $id)
    {
        try {

            $this->request->validate([
                'start' => 'required|date_format:d/m/Y',
                'finish' => 'required|date_format:d/m/Y'
            ]);

            $situation = $this->service->getResourceSituation($this->request->all(), $id);

            return $this->response->json($situation, 200);
        } catch (ValidatorException $e) {
            return $this->response->json($e->getMessageBag(), 422);
        }
    }
}
