<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->date('billing_date');
            $table->date('payday')->nullable();
            $table->string('status');
            $table->decimal('value_paid');

            $table->unsignedInteger('group_company_id');
            $table->foreign('group_company_id')
                ->references('id')
                ->on('group_companies');

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
        Schema::dropIfExists('payment_transactions');
        Schema::enableForeignKeyConstraints();
    }
}
