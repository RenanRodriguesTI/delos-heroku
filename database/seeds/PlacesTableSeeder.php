<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now()->toDateTimeString();

        DB::table('places')->insert([
            ['name' => 'Escritório', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'Campo / Escritório Cliente', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'Home Office', 'created_at' => $date, 'updated_at' => $date]
        ]);
    }
}
