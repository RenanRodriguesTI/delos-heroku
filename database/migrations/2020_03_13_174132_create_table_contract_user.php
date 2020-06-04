<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableContractUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_project',function(Blueprint $table){
                $table->integer('contracts_id')->unsigned();;
                $table->integer('project_id')->unsigned();
                $table->foreign('contracts_id')->references('id')->on('contracts');
                $table->foreign('project_id')->references('id')->on('projects');
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::dropIfExists('contract_user');
    }
}
