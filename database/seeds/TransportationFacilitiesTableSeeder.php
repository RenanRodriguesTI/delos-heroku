<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransportationFacilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $date = Carbon::now()->toDateString();

        DB::table('transportation_facilities')->insert([
            ['name' => 'Aéreo', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'Rodoviário', 'created_at' => $date, 'updated_at' => $date],
        ]);
    }
}
