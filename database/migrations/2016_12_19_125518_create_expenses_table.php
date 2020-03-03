<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        // DB::table('expense_types')->insert([
        //     ['name' => 'Almoço'],
        //     ['name' => 'Jantar'],
        //     ['name' => 'Taxi'],
        //     ['name' => 'Combustível'],
        // ]);

        Schema::create('payment_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        // DB::table('payment_types')->insert([
        //     ['name' => 'money'],
        //     ['name' => 'bank card'],
        // ]);

        Schema::create('expenses', function(Blueprint $table) {
            $table->increments('id');
            $table->string('invoice');
            $table->date('issue_date');
            $table->float('value');
            $table->integer('payment_type_id')->unsigned();
            $table->string('description');
            $table->string('note')->nullable(true);
            $table->integer('user_id')->unsigned();
            $table->integer('request_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('payment_type_id')->references('id')->on('payment_types')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('expenses');
        Schema::drop('payment_types');
        Schema::drop('expense_types');
    }
}