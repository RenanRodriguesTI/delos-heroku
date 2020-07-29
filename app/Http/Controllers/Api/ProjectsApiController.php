<?php

namespace Delos\Dgp\Http\Controllers\Api;
use Validator;
use Illuminate\Http\Request;
use Delos\Dgp\Http\Controllers\Controller;
use Delos\Dgp\Entities\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Exception;

class ProjectsApiController  extends Controller
{
    public function showByUser(Request $request)
    {
        $data = $request["data"];
        $id = $request["id"];
     


        $validator = 
        Validator::make($request->all(), [
            "data"=>"required|date",
            "id"=>"required|numeric"
        ]); 

        if($validator->fails())
        return response()->json([
            "found"=>false,
            "message"=>$validator->errors()
        ],412);
        $data = \Carbon\Carbon::parse($data)->format('d-m-Y');

       $projects = DB::select("
       SELECT * FROM projects
       where (finish >= STR_TO_DATE(:data,'%d-%m-%Y') or extension >= STR_TO_DATE(:data2,'%d-%m-%Y'))
       and id in 
       (Select project_id from project_user where user_id = :idUser ) 
       and deleted_at is null
       group by projects.id",['idUser'=>$id,'data'=>$data,'data2'=>$data]);

        if ($projects != null&& sizeof($projects)>0) {

            $projects = collect($projects);
            $projects = $projects->map(function($project) use($id,$data){
                $allocations = DB::select("
                SELECT start,finish FROM allocations WHERE parent_id in (SELECT id FROM allocations
                WHERE user_id=:userid
                and project_id =:project and finish >= STR_TO_DATE(:data,'%d-%m-%Y') and parent_id is null)",['userid'=>$id,'data'=>$data,'project' =>$project->id]);
                $project->allocations = $allocations;
                return $project;
            });
            return response()->json([
                "found" => true,
                "projects" => $projects,
            ]);
        }

        return response()->json([
            "found" => false,
            "message" => "Record not found",
        ], 400);
    }

    public function showUsers()
    {
        $users = DB::select("select user_id,name from project_user p inner join users u on p.user_id = u.id  where project_id = :idproject", ["idproject" => $idproject]);

        if ($users != null && sizeof($users)>0) {
            return response()->json([
                "found" => true,
                "projectusers" => $users,
            ]);
        }

        return response()->json([
            "found" => false,
            "message" => "Record not found",
        ], 404);
    }


    public function tasks(int $projectId)
    {
        try{
            $found = Project::find($projectId);

            if($found){
                $tasks = $found->tasks;
               
                if(!$tasks->isEmpty()){
                    $result = [];
                    foreach($tasks as $task){
                        $result[] = ['id' => $task->id,'name' =>$task->name];
                    }
                    
                    return response()->json([
                        "found" => true,
                        "tasks" => $result,
                    ], 200);
                } else{
                    return response()->json([
                        "found" => false,
                        "message" => "Tasks not found",
                    ], 404);
                }
            } else{
                return response()->json([
                    "found" => false,
                    "message" => "Project not found",
                ], 404);
            }
        } catch(Exception $err){
            return response()->json([
                "found" => false,
                "message" => "error internal server",
            ], 500);
        }
    }
}
