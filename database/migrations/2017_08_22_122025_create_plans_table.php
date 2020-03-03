<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->enum('billing_type', ['auto', 'manual']);
            $table->enum('periodicity', ['WEEKLY', 'MONTHLY', 'BIMONTHLY', 'TRIMONTHLY', 'SEMIANNUALLY', 'YEARLY']);
            $table->decimal('value');
            $table->integer('trial_period');
            $table->integer('max_users')->nullable();
            $table->timestamps();
        });

        $datas = [
            ['name' => 'Caburé', 'billing_type' => 'auto', 'periodicity' => 'MONTHLY', 'value' => '10.00', 'trial_period' => '0', 'max_users' => '0'],
            ['name' => 'Aluco', 'billing_type' => 'auto', 'periodicity' => 'MONTHLY', 'value' => '20.00', 'trial_period' => '0', 'max_users' => '0'],
            ['name' => 'Jacurutu', 'billing_type' => 'auto', 'periodicity' => 'MONTHLY', 'value' => '25.00', 'trial_period' => '0', 'max_users' => '0'],

        ];

        foreach ($datas as $data) {
            \DB::transaction(function () use ($data){
                \DB::table('plans')->insert($data);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
