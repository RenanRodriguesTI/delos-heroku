<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('states')->insert([
            ['name' => 'RO'],
            ['name' => 'AC'],
            ['name' => 'AM'],
            ['name' => 'RR'],
            ['name' => 'PA'],
            ['name' => 'AP'],
            ['name' => 'TO'],
            ['name' => 'MA'],
            ['name' => 'PI'],
            ['name' => 'CE'],
            ['name' => 'RN'],
            ['name' => 'PB'],
            ['name' => 'PE'],
            ['name' => 'AL'],
            ['name' => 'SE'],
            ['name' => 'BA'],
            ['name' => 'MG'],
            ['name' => 'ES'],
            ['name' => 'RJ'],
            ['name' => 'SP'],
            ['name' => 'PR'],
            ['name' => 'SC'],
            ['name' => 'RS'],
            ['name' => 'MS'],
            ['name' => 'MT'],
            ['name' => 'GO'],
            ['name' => 'DF']
        ]);
    }
}
