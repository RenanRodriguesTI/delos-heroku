<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAtributesPaymentTypeProviders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_type_providers',function(Blueprint $table){
            $table->boolean('ative')->default(true);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_type_providers',function(Blueprint $table){
            $table->dropColumn('ative');
            $table->dropSoftDeletes();
        });
    }
}
