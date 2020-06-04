<?php

namespace Delos\Dgp\Http\Controllers\Api;

use Illuminate\Http\Request;
use Delos\Dgp\Http\Controllers\Controller;
use Delos\Dgp\Entities\Place;
use Illuminate\Support\Facades\DB;
use Exception;

class PlaceApiController extends Controller
{
    public function show(Request $request){
        try{
            $places = DB::select('select id,name from places');
            
            if($places && count($places)>0){
                return response()->json([
                    'found' => true,
                    'places' => $places
                ],200);
            }
            return response()->json([
                'found' => false,
                'message' => 'Places not found'
            ],404);
        } catch(Exception $err){
            return response()->json([
                'found' => false,
                'message' => 'error internal server'
            ],500);
        }
    }
}
