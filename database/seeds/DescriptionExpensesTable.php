<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DescriptionExpensesTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now()->toDateTimeString();
        DB::table('description_expenses')->insert([
            ['name'=>'Passagem', 'created_at' => $date, 'updated_at' => $date],
            ['name'=>'Hospedagem', 'created_at' => $date, 'updated_at' => $date],
            ['name'=>'Locação de veiculos', 'created_at' => $date, 'updated_at' => $date],
        ]);
    }
}
