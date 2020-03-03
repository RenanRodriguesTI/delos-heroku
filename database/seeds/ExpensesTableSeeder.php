<?php

use Delos\Dgp\Entities\Expense;
use Illuminate\Database\Seeder;

class ExpensesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Expense::class)->times(10)->create();
    }
}
