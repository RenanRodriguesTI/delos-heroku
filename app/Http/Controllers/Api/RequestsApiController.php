<?php

namespace Delos\Dgp\Http\Controllers\Api;
use Validator;
use Illuminate\Http\Request;
use Delos\Dgp\Http\Controllers\Controller;
use Delos\Dgp\Entities\Request as RequestModel;
use Illuminate\Support\Facades\DB;

class RequestsApiController extends Controller
{
    public function  showByRequest(Request $request){
      $id =$request["id"];
      $data = $request["data"];


     $validator= 
     Validator::make($request->all(), [
      "data"=>"required|date",
      "id"=>"required"
    ]);

    if($validator->fails())
      return response()->json([
          "found"=>false,
          "message"=>$validator->errors()
      ],412);

    
      $data = \Carbon\Carbon::parse($data)->format('Y-m-d');
      $requests=  DB::select("select * from request_user ru inner join requests r on r.id = ru.request_id where ru.user_id = :id and deleted_at is null and STR_TO_DATE(:data, '%Y-%m-%d') <= finish", ["id"=>$id,"data"=>$data]);

      if($request!=null && sizeof($requests))
        return response()->json([
            "found"=>true,
            "requests"=>$requests
        ],200);
      else
      return response()->json([
        "found"=>false,
        "message"=> "Record not found"
    ],404);
    }
}
