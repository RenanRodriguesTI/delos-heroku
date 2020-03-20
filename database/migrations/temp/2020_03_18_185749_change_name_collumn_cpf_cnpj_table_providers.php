<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNameCollumnCpfCnpjTableProviders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('providers', function(Blueprint $table){
            $table->renameColumn('cpf_cnpj','cnpj');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('providers',function(Blueprint $table){
            $table->renameColumn('cnpj','cpf_cnpj');
        });
    }
}
