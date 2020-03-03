<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Delos\Dgp\Entities\PaymentType;

class TraslatePtBrTypePaymentInDataBase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $types =["money","bank card","mobility card","99 taxi"];
        $cod =["000001","000002","000003","000004"];
        $typespt =["Dinheiro","Cartão Safra","Cartão Alelo","99 Táxi"];

        for($i=0;$i < sizeof($types);$i++){

            \DB::transaction(function () use ($typespt,$i,$cod){
                \DB::update('update payment_types set name=:typespt where cod = :cod', 
                ['cod'=>$cod[$i],
                'typespt' =>$typespt[$i] ]);
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
        $types =["money","bank card","mobility card","99 taxi"];
        $typespt =["Dinheiro","Cartão Safra","Cartão Alelo","99 Táxi"];
        $cod =["000001","000002","000003","000004"];
        for($i=0;$i < sizeof($typespt);$i++){
            \DB::transaction(function () use ($typespt,$i,$cod){
                \DB::update('update payment_types set name = :types where cod = :cod', 
                ['cod'=>$cod[$i],
                'typespt' =>$typespt[$i] ]);
            });
        }
    }
}
