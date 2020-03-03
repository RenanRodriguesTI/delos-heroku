<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FinancialRatingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now()->toDateTimeString();

        DB::table('financial_ratings')->insert([
            ['cod' => '02', 'description' =>'Despesas por conta da empresa', 'created_at' => $date, 'updated_at' => $date],
            ['cod' => '03', 'description' =>'Despesas por conta do cliente', 'created_at' => $date, 'updated_at' => $date]
        ]);
    }
}
