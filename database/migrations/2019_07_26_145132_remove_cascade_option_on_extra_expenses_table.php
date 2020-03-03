<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveCascadeOptionOnExtraExpensesTable extends Migration
{

    public function up()
    {
        Schema::table('extra_expenses', function (Blueprint $table) {
            $table->dropForeign('extra_expenses_ibfk_1');
            $table->foreign('request_id')
                ->references('id')
                ->on('requests');
        });
    }

    public function down()
    {
        Schema::table('extra_expenses', function (Blueprint $table) {
            $table->dropForeign('extra_expenses_request_id_foreign');
            $table->foreign('request_id', 'extra_expenses_ibfk_1')
                ->references('id')
                ->on('requests')
                ->onDelete('cascade');
        });
    }
}
