<?php

namespace Delos\Dgp\Http\Controllers\Api;
use Delos\Dgp\Entities\Plan;
use Illuminate\Http\Request;
use Delos\Dgp\Http\Controllers\Controller;

class PlansApiController extends Controller
{
    public function create(Request $request){
        $objplano = [
        "titulodoplano"=>"",
        "diasparateste"=>"",
        "valor"=>"",
        "descricao"=>"",
        "tipodecobranca" =>"",
        "periododecobranca"=>"",
        "quantidadeMaxuser" =>""];

        $plans = Plan::create([
            "name"=>$request["name"], 
            "biling_type"=>$request["biling_type"], 
            "periodicity"=>$request["periodicity"],
            "value"=>$request["value"],
            "trial_period"=>$request["trial_period"], 
            "max_users" =>$request["max_users"],
            "description"=>$request["description"]
            ]);

        return response()->json($plans);
    }

    public function delete(){

    }

    public function show($id= null){

       if($id != null){
        $plan = Plan::where("id",$id)->get();
       }
       else{
           $plan = Plan::all();
       }
       
       return response()->json($plan);
    }


   
}
