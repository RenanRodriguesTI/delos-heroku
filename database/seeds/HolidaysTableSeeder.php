<?php

use Delos\Dgp\Entities\Holiday;
use Illuminate\Database\Seeder;

class HolidaysTableSeeder extends Seeder
{

    private $holiday;

    public function __construct(Holiday $holiday)
    {

        $this->holiday = $holiday;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['description' => 'Confraternização Universal', 'date' => '01/01/2017'],
            ['description' => 'Aniversário da Cidade de São Paulo', 'date' => '25/01/2017'],
            ['description' => 'Carnaval', 'date' => '28/02/2017'],
            ['description' => 'Sexta-feira Santa', 'date' => '14/04/2017'],
            ['description' => 'Tiradentes', 'date' => '21/04/2017'],
            ['description' => 'Dia do Trabalhador', 'date' => '01/05/2017'],
            ['description' => 'Corpus Christi', 'date' => '15/06/2017'],
            ['description' => 'Revolução Constitucionalista de 1932', 'date' => '09/07/2015'],
            ['description' => 'Independência do Brasil', 'date' => '07/09/2017'],
            ['description' => 'Padroeira do Brasil', 'date' => '12/10/2017'],
            ['description' => 'Finados', 'date' => '02/11/2017'],
            ['description' => 'Proclamação da República', 'date' => '15/11/2017'],
            ['description' => 'Natal', 'date' => '25/12/2017'],
        ];

        foreach($data as $holiday) {
            $this->holiday->create($holiday);
        }
    }
}
