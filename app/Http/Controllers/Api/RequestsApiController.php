<?php

namespace Delos\Dgp\Http\Controllers\Api;

use Delos\Dgp\Entities\Allocation;
use Validator;
use Illuminate\Http\Request;
use Delos\Dgp\Http\Controllers\Controller;
use Delos\Dgp\Entities\Request as RequestModel;
use Illuminate\Support\Facades\DB;

class RequestsApiController extends Controller
{
  public function  showByRequest(Request $request)
  {
    $id = $request["id"];
    $data = $request["data"];


    $validator =
      Validator::make($request->all(), [
        "data" => "required|date",
        "id" => "required"
      ]);

    if ($validator->fails())
      return response()->json([
        "found" => false,
        "message" => $validator->errors()
      ], 412);


    $data = \Carbon\Carbon::parse($data)->format('Y-m-d');

    $requests=  DB::select("select * from request_user ru inner join requests r on r.id = ru.request_id where ru.user_id = :id and deleted_at is null and STR_TO_DATE(:data, '%Y-%m-%d') <= finish", ["id"=>$id,"data"=>$data]);
    $requests = RequestModel::whereHas('users', function ($query) use ($data, $id) {
      return  $query->where('id', $id);
    })->where('finish', '>=', $data)->get()->map(function ($item) use($id) {

      $allocations = Allocation::where('user_id',$id)
      ->where('project_id',$item->project_id)
      ->whereNotNull('parent_id')
      ->get() 
      ->map(function($item){
            return [
                'start' => $item->start->format('Y-m-d'),
                'finish' => $item->finish->format('Y-m-d')
            ];
      });
      return [
        "id" => $item->id,
        "requester_id" => $item->requester_id,
        "project_id" => $item->project_id,
        "parent_id" => $item->parent_id,
        "created_at" => $item->created_at->format('Y-m-d H:i:s'),
        "updated_at" => $item->updated_at->format('Y-m-d H:i:s'),
        "approved" => $item->approved,
        "reason" => $item->reason,
        "deleted_at" => $item->deleted_at ? $item->deleted_at->format('Y-m-d') : null ,
        "start" => $item->start->format('Y-m-d'),
        "finish" => $item->finish->format('Y-m-d'),
        "approver_id" => $item->approver_id,
        "notes" => $item->notes,
        'allocations' => $allocations,
        "project" =>[
          'compiled_cod' => $item->project->compiled_cod,
          'description' => $item->project->description
        ],
      ];
    });
    if ($request != null && sizeof($requests))
      return response()->json([
        "found" => true,
        "requests" => $requests
      ], 200);
    else
      return response()->json([
        "found" => false,
        "message" => "Record not found"
      ], 404);
  }
}
