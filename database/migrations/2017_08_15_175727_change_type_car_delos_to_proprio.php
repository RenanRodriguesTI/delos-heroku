<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTypeCarDelosToProprio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::table('car_types')->where('name', 'Próprio')->update(['name' => 'Próprio do funcionario']);
        \DB::table('car_types')->where('name', 'Delos')->update(['name' => 'Próprio da empresa']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('car_types', function (Blueprint $table) {
            \DB::table('car_types')->where('name', 'Próprio do funcionario')->update(['name' => 'Próprio']);
            \DB::table('car_types')->where('name', 'Próprio da empresa')->update(['name' => 'Delos']);
        });
    }
}
