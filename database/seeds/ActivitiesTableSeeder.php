<?php

use Illuminate\Database\Seeder;
use Delos\Dgp\Entities\Activity;

class ActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Activity::class, 10)->create();
    }
}
