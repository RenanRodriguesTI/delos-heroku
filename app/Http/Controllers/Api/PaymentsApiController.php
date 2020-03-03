<?php

namespace Delos\Dgp\Http\Controllers\Api;

use Illuminate\Http\Request;
use Delos\Dgp\Http\Controllers\Controller;
use Delos\Dgp\Entities\PaymentType;


class PaymentsApiController  extends Controller
{
    public function showByPaymenttypes(){
        $paymentstypes= PaymentType::all();

        if($paymentstypes!=null)
        return response()->json([
            "found"=>true,
            "paymentstypes"=>$paymentstypes
        ],200);
        else
        return response()->json([
            "found"=>false,
            "message"=>"Record not found"
        ],404);
    }
}
