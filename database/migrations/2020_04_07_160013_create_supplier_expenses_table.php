<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->date('issue_date');
            $table->float('value');
            $table->integer('payment_type_provider_id')->unsigned();
            $table->integer('description_id')->unsigned();
            $table->string('note')->nullable(true);
            $table->integer('provider_id')->unsigned();
            $table->integer('establishment_id')->unsigned();
            $table->integer('voucher_type_id')->unsigned();
            $table->integer('project_id')->unsigned()->nullable(true);
            $table->integer('debit_memo_id')->unsigned()->nullable(true);
            $table->char('original_name');
            $table->char('s3_name');
            $table->boolean('exported');
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('payment_type_provider_id')->references('id')->on('payment_type_providers')->onDelete('cascade');
            $table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade');
            $table->foreign('voucher_type_id')->references('id')->on('voucher_types')->onDelete('cascade');
            $table->foreign('description_id')->references('id')->on('description_expenses')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplier_expenses');
    }
}
