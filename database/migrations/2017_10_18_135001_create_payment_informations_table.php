<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_informations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->json('document')->nullable();
            $table->boolean('is_bank_slip')->nullable();
            $table->json('address')->nullable();
            $table->json('credit_card')->nullable();
            $table->unsignedInteger('group_company_id')->nullable();
            $table->foreign('group_company_id')->references('id')->on('group_companies');
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('payment_informations');
        Schema::enableForeignKeyConstraints();
    }
}
