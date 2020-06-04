<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentTypeProvidersTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now()->toDateTimeString();
        $date = Carbon::now()->toDateTimeString();
        DB::table('payment_type_providers')->insert([
            ['name'=>'Conta Corrente', 'created_at' => $date, 'updated_at' => $date],
            ['name'=>'Cartão Passagem', 'created_at' => $date, 'updated_at' => $date],
            ['name'=>'Cartão Delos', 'created_at' => $date, 'updated_at' => $date],
        ]);
    }
}
