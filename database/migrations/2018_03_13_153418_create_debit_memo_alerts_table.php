<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDebitMemoAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debit_memo_alerts', function (Blueprint $table) {
            $table->increments('id');
            $table->float('value');

            $table->unsignedInteger('debit_memo_id');
            $table->foreign('debit_memo_id')->references('id')->on('debit_memos');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('debit_memo_alerts');
    }
}
