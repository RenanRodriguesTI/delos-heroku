<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('project_types')->insert([
            ['name' => 'Unitização'],
            ['name' => 'Laudo BRR'],
            ['name' => 'Transferência de Ativos'],
            ['name' => 'Inventário de Bens Móveis'],
            ['name' => 'Administrativo'],
        ]);
    }
}
