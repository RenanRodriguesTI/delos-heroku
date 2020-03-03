<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Delos\Dgp\Entities\PaymentType;

class InsertNewTypePayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $datas = [['name' =>'99 taxi','cod'=>'000004']];
        foreach($datas as $data){
            \DB::transaction(function () use ($data){
                \DB::table('payment_types')->insert($data);
            });

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

       $paymenttype = PaymentType::where('name', '99 taxi')->first();
       $paymenttype->delete();
    }
}
