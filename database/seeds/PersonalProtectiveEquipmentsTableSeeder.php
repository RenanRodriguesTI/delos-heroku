<?php

use Illuminate\Database\Seeder;
use Delos\Dgp\Entities\PersonalProtectiveEquipment;

class PersonalProtectiveEquipmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(PersonalProtectiveEquipment::class, 10)->create();
    }
}
