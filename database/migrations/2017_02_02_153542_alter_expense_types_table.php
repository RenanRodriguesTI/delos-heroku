<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterExpenseTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::table('expense_types')->truncate();

        Schema::table('expense_types', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->char('cod');
            $table->string('description');
        });

        $datas = [
            ['cod' =>' 001', 'description' => 'Passagens ' ],
            ['cod' =>' 001-01', 'description' => 'Passagens - Tam ' ],
            ['cod' =>' 001-02', 'description' => 'Passagens - Gol ' ],
            ['cod' =>' 001-03', 'description' => 'Passagens - Avianca ' ],
            ['cod' =>' 001-04', 'description' => 'Passagens - Gabrielli ' ],
            ['cod' =>' 002', 'description' => 'Cafe da Manhã ' ],
            ['cod' =>' 003', 'description' => 'Almoço ' ],
            ['cod' =>' 004', 'description' => 'Jantar ' ],
            ['cod' =>' 005', 'description' => 'Abastecimento ' ],
            ['cod' =>' 006', 'description' => 'Pedagio ' ],
            ['cod' =>' 007', 'description' => 'Quilometragem ' ],
            ['cod' =>' 008', 'description' => 'Hospedagem ' ],
            ['cod' =>' 008-01', 'description' => 'Hospedagem Solare ' ],
            ['cod' =>' 008-02', 'description' => 'Hospedagem Novotel ' ],
            ['cod' =>' 008-03', 'description' => 'Hospedagem Ibis ' ],
            ['cod' =>' 008-04', 'description' => 'Hospedagem Lavanderia ' ],
            ['cod' =>' 008-05', 'description' => 'Hospedagem Extras ' ],
            ['cod' =>' 009', 'description' => 'Táxi ' ],
            ['cod' =>' 009-01', 'description' => 'Táxi Guarucoop ' ],
            ['cod' =>' 009-02', 'description' => 'Táxi Radio Ilhasat ' ],
            ['cod' =>' 009-03', 'description' => 'Táxi Ligue Táxi ' ],
            ['cod' =>' 009-04', 'description' => 'Táxi Coop. de Radio Táxi Ilha ' ],
            ['cod' =>' DC-DS', 'description' => 'Tcia da Delos Consultoria para Delos Serviços ' ],
            ['cod' =>' TARIFA', 'description' => 'Tarifa Bancarias do dia ' ],
            ['cod' =>' TCIA C', 'description' => 'Transferencia para Caixa Master ' ],
        ];

        // \DB::transaction(function () use ($datas) {
        //     foreach ($datas as $data) {
        //         \DB::table('expense_types')->insert($data);
        //     }
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expense_types', function (Blueprint $table) {
            $table->dropColumn(['cod', 'description']);
            $table->string('name');
        });

        $datas = [
            ['name' => 'Almoço'],
            ['name' => 'jantar'],
            ['name' => 'Taxi'],
            ['name' => 'Combustível'],
        ];

        // \DB::transaction(function () use ($datas) {
        //     foreach ($datas as $data) {
        //         \DB::table('expense_types')->insert($data);
        //     }
        // });
    }
}
