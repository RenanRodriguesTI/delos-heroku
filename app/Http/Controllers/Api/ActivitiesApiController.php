<?php

namespace Delos\Dgp\Http\Controllers\Api;

use Illuminate\Http\Request;
use Delos\Dgp\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Exception;
use Prettus\Validator\Exceptions\ValidatorException;


class ActivitiesApiController extends AbstractController
{
    public function activitiesByUser(int $id){
        try{
            $activities = DB::select('
            SELECT a.id,pj.compiled_cod as project_cod_compiled,a.date,a.hours,t.name as task,p.name as place,a.note,a.created_at,a.approved,a.concluded
            FROM activities a 
            inner join users u on a.user_id = u.id
            inner join tasks t on a.task_id = t.id
            inner join places p on a.place_id = p.id 
            inner join projects pj on pj.id = a.project_id where a.user_id = :id and u.deleted_at is null',['id' =>$id]);

            if($activities && count($activities) >0){
                return $this->response->json([
                    'found' => true,
                    'activities' =>$activities
                ],200);
            }

            return $this->response->json([
                'found' => false,
                'message' => 'not found'
            ],404);
        } catch(Exception $err){
            return $this->response->json([
                'found' => false,
                'message' =>'error internal server'
            ],500);
        }
    }


    public function store()
    {
        try {
            $this->request['include_non_working_days'] = false;
            $this->service->create($this->request->all());

            return $this->response->json([
                'status' =>true,
                'message' => 'activity created'],200);

        } catch ( ValidatorException $e ) {
            return $this->response->json([
                'status' => false,
                'message' => $e->getMessageBag()
            ],422);
        }

    }
}
