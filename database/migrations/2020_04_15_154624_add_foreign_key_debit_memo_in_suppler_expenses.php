<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyDebitMemoInSupplerExpenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supplier_expenses',function(Blueprint $table){
            $table->foreign('debit_memo_id')->references('id')->on('debit_memos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supplier_expenses',function(Blueprint $table){
            $table->dropForeign(['debit_memo_id']);
        });
    }
}
