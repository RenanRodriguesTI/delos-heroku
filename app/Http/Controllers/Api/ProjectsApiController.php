<?php

namespace Delos\Dgp\Http\Controllers\Api;
use Validator;
use Illuminate\Http\Request;
use Delos\Dgp\Http\Controllers\Controller;
use Delos\Dgp\Entities\Project;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class ProjectsApiController extends Controller
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

       $projects = DB::select("select * from project_user pu inner join  projects p on pu.project_id =  p.id  where pu.user_id =:iduser and deleted_at is null and STR_TO_DATE(:data, '%d-%m-%Y') <= finish",["iduser"=>$id,"data"=>$data]);

        if ($projects != null&& sizeof($projects)>0) {
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
}
