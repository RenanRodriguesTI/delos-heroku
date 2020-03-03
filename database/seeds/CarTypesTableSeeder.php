<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CarTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now();

        DB::table('car_types')->insert([
            ['name' => 'Locado', 'created_at' => $date->toDateString(), 'updated_at' => $date->toDateString()],
            ['name' => 'Próprio', 'created_at' => $date->toDateString(), 'updated_at' => $date->toDateString()],
            ['name' => 'Delos', 'created_at' => $date->toDateString(), 'updated_at' => $date->toDateString()]
        ]);
    }
}
