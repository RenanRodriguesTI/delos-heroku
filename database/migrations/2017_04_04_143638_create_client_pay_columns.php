<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientPayColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->boolean('client_pay')->nullable();
        });
        
        Schema::table('lodgings', function (Blueprint $table) {
            $table->boolean('client_pay')->nullable();
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->boolean('client_pay')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn('client_pay');
        });

        Schema::table('lodgings', function (Blueprint $table) {
            $table->dropColumn('client_pay');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('client_pay');
        });
    }
}
