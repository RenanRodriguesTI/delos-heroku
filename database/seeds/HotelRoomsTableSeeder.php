<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelRoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hotel_rooms')->insert([
            ['name' => 'Individual'],
            ['name' => 'Duplo'],
            ['name' => 'Triplo'],
        ]);
    }
}
