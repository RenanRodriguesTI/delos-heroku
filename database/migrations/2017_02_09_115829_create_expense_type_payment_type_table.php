<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenseTypePaymentTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_type_payment_type', function (Blueprint $table) {
            $table->unsignedInteger('expense_type_id');
            $table->foreign('expense_type_id')->references('id')->on('expense_types')->onDelete('cascade');

            $table->unsignedInteger('payment_type_id');
            $table->foreign('payment_type_id')->references('id')->on('payment_types')->onDelete('cascade');

            $table->primary(['expense_type_id', 'payment_type_id'], 'expense_type_payment_type_expensetype_id_paymenttype_id_primary');
        });

        $datas = [
            ['expense_type_id' => '1', 'payment_type_id' => '1'],
            ['expense_type_id' => '2', 'payment_type_id' => '1'],
            ['expense_type_id' => '3', 'payment_type_id' => '1'],
            ['expense_type_id' => '4', 'payment_type_id' => '1'],
            ['expense_type_id' => '5', 'payment_type_id' => '1'],
            ['expense_type_id' => '6', 'payment_type_id' => '1'],
            ['expense_type_id' => '7', 'payment_type_id' => '1'],
            ['expense_type_id' => '8', 'payment_type_id' => '1'],
            ['expense_type_id' => '9', 'payment_type_id' => '1'],
            ['expense_type_id' => '10', 'payment_type_id' => '1'],
            ['expense_type_id' => '11', 'payment_type_id' => '1'],
            ['expense_type_id' => '12', 'payment_type_id' => '1'],
            ['expense_type_id' => '13', 'payment_type_id' => '1'],
            ['expense_type_id' => '14', 'payment_type_id' => '1'],
            ['expense_type_id' => '15', 'payment_type_id' => '1'],
            ['expense_type_id' => '16', 'payment_type_id' => '1'],
            ['expense_type_id' => '17', 'payment_type_id' => '1'],
            ['expense_type_id' => '23', 'payment_type_id' => '1'],
            ['expense_type_id' => '24', 'payment_type_id' => '1'],
            ['expense_type_id' => '25', 'payment_type_id' => '1'],
            ['expense_type_id' => '1', 'payment_type_id' => '2'],
            ['expense_type_id' => '2', 'payment_type_id' => '2'],
            ['expense_type_id' => '3', 'payment_type_id' => '2'],
            ['expense_type_id' => '4', 'payment_type_id' => '2'],
            ['expense_type_id' => '5', 'payment_type_id' => '2'],
            ['expense_type_id' => '6', 'payment_type_id' => '2'],
            ['expense_type_id' => '7', 'payment_type_id' => '2'],
            ['expense_type_id' => '8', 'payment_type_id' => '2'],
            ['expense_type_id' => '9', 'payment_type_id' => '2'],
            ['expense_type_id' => '10', 'payment_type_id' => '2'],
            ['expense_type_id' => '11', 'payment_type_id' => '2'],
            ['expense_type_id' => '12', 'payment_type_id' => '2'],
            ['expense_type_id' => '13', 'payment_type_id' => '2'],
            ['expense_type_id' => '14', 'payment_type_id' => '2'],
            ['expense_type_id' => '15', 'payment_type_id' => '2'],
            ['expense_type_id' => '16', 'payment_type_id' => '2'],
            ['expense_type_id' => '17', 'payment_type_id' => '2'],
            ['expense_type_id' => '23', 'payment_type_id' => '2'],
            ['expense_type_id' => '24', 'payment_type_id' => '2'],
            ['expense_type_id' => '25', 'payment_type_id' => '2'],
        ];

        // \DB::transaction(function () use ($datas) {
        //     foreach ($datas as $data) {
        //         \DB::table('expense_type_payment_type')->insert($data);
        //     }
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expense_type_payment_type');

        \DB::table('payment_types')->where('name', 'voucher')->delete();
    }
}
