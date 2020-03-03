<?php

use Illuminate\Database\Seeder;
use Delos\Dgp\Entities\Equipment;

class EquipmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Equipment::class, 10)->create();
    }
}
