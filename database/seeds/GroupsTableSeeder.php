<?php

use Illuminate\Database\Seeder;
use Delos\Dgp\Entities\Group;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Group::class, 10)->create();
    }
}
