<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteForeignKeyDescriptionInSupplierExpenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supplier_expenses', function(Blueprint $table){
            $table->dropForeign(['description_id']);
            $table->dropIndex('supplier_expenses_description_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supplier_expenses', function(Blueprint $table){
            $table->foreign('description_id')->references('id')->on('description_expenses')->onDelete('cascade');
        });
    }
}
