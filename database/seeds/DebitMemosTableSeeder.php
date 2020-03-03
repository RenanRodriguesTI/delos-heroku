<?php
use Delos\Dgp\Entities\DebitMemo;
use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * User: allan
 * Date: 18/07/17
 * Time: 12:41
 */
class DebitMemosTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(DebitMemo::class)->times(10)->create();
    }
}