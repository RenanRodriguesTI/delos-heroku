<?php

namespace Delos\Dgp\Http\Controllers\Api;

use Illuminate\Http\Request;
use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;
use Carbon\Carbon;
use Exception;
use Firebase\JWT\SignatureInvalidException;
use Validator;
use Delos\Dgp\Http\Controllers\Controller;

class LicenseController extends Controller
{
    public function license(Request $request){
         try{
            $key = 'XsWDoDHoOG1ID/q/UlZmOWXr8L+H6UMs0H3hsVdDmuM=';
          

            $validator= 
          Validator::make($request->all(), [
              "license"=>"required"
          ]);
  
          if($validator->fails())
              return response()->json([
                  "status"=>false,
                  "message"=>$validator->errors()
              ],422);
              
         
      
    
           $decoded = JWT::decode($request->input('license'), $key, ['HS256']);
           return response()->json(["license" => $request->input('license')],200);
         } catch(Exception $err){

            if($err instanceof ExpiredException){
                return response()->json([
                    'status' =>false,
                    'message' =>'expired token'
                ],422);
            }


            if($err instanceof SignatureInvalidException){
                return response()->json([
                    'status' =>false,
                    'message' =>'invalid token'
                ],422);
            }
            return response()->json([
                'status' =>false,
                'message' =>'error internal server'
            ],500);
         }
    }

    public function create(Request $request){
        try{
            $key = 'XsWDoDHoOG1ID/q/UlZmOWXr8L+H6UMs0H3hsVdDmuM=';
            $dateCarbon = Carbon::now();
            $dateCarbon->addDays(30);
            $dateCarbon->setTime(23,59,59);
            $token_payload = [
                'iss'=> 'https://delos2.com.br/',
                'user_id' =>$request->input('user_id'),
                'iat'=>Carbon::now()->timestamp,
                'exp'=> $dateCarbon->timestamp,
            ];


            $validator= 
            Validator::make($request->all(), [
                "user_id"=>"required"
            ]);

            if($validator->fails()){
                return response()->json([
                    "status"=>false,
                    "message"=>$validator->errors()
                ],422);
            }

            $jwt = JWT::encode($token_payload, $key, 'HS256');
            return response()->json(['license' =>$jwt],201);

        }  catch(Exception $err){
            return response()->json([
                'status' =>false,
                'message' =>'error internal server'
            ]);
        }
    }
}
