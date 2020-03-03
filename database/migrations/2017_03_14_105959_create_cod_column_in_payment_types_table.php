<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodColumnInPaymentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_types', function (Blueprint $table) {
            $table->char('cod', 6);
        });

        \DB::table('payment_types')->where('name', '=', 'money')->update(['cod' => '000001']);
        \DB::table('payment_types')->where('name', '=', 'bank card')->update(['cod' => '000002']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_types', function (Blueprint $table) {
            $table->dropColumn('cod');
        });
    }
}
