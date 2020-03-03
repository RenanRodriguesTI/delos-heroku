<?php

use Delos\Dgp\Entities\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Role::class)->create(['name' =>'Collaborator']);
        factory(Role::class)->create(['name' =>'Manager']);
        factory(Role::class)->create(['name' =>'Administrative']);
        factory(Role::class)->create(['name' =>'Administrator']);
        factory(Role::class)->create(['name' =>'Root']);
        factory(Role::class)->create(['name' =>'Client']);
        factory(Role::class)->create(['name' =>'Comercial']);
    }
}