<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VoucherTypesTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now()->toDateTimeString();
        DB::table('voucher_types')->insert([
            ['name'=>'Reserva', 'created_at' => $date, 'updated_at' => $date],
            ['name'=>'E-mail', 'created_at' => $date, 'updated_at' => $date],
            ['name'=>'Recibo', 'created_at' => $date, 'updated_at' => $date],
            ['name'=>'Nota Fiscal', 'created_at' => $date, 'updated_at' => $date],
        ]);
    }
}
