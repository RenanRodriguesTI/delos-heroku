<?php

namespace Delos\Dgp\Http\Controllers\Api;

use Illuminate\Http\Request;
use Delos\Dgp\Http\Controllers\Controller;
use Delos\Dgp\Repositories\Contracts\AppVersionApiRepository;
use Exception;

class AppVersionApiController extends Controller
{
    public function last(){
        try{
            $version= app(AppVersionApiRepository::class)->scopeQuery(function($query){
                return $query->orderBy('created_at','desc');
           })->first();
           
           
           if($version){
            return response()->json([
                'found' => true,
                'version' => $version->version,
                'important' =>$version->important
            ],200);
           }

           return response()->json([
            'found' => false,
            'message' =>'not found version'
           ],404);
        } catch(Exception $err){
            return response()->json([
                'found'=>false,
                'message' =>'error internal server'
            ],500);
        }
     
    }
}
