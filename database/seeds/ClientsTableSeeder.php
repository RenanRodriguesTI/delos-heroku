<?php

use Illuminate\Database\Seeder;
use Delos\Dgp\Entities\Client;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Client::class, 10)->create();
    }
}
