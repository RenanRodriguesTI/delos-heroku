<?php

use Delos\Dgp\Entities\Module;
use Delos\Dgp\Entities\Permission;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        
        $modules = [
            'Controle de Atividades feitas no Projeto, para levantamento de horas trabalhadas',
            'Gerenciamento de Projetos',
            'Controle de Tarefas para Atividades',
            'Controle de Tipos de Projeto para melhor classificar os serviços prestados',
            'Controle de Despesas',
            'Controle de Notas de Débito gerada através das Despesas',
            'Gerenciamento de Grupos de Clientes',
            'Gerenciamento de Clientes',
            'Gerenciamento de usuários do sistema',
            'Controle de Solicitações para prestação de serviço, tais como Passagem, Hospedagem, Táxi etc.',
            'Gerenciamento Multi Empresas',
            'Controle através de Classificações Financeiras',
            'Controle de Folgas'
        ];

        foreach ($modules as $module) {
            \DB::transaction(function () use ($module) {
                \DB::table('modules')->insert(['name' => $module]);
            });
        }


        Schema::create('module_permission', function (Blueprint $table) {
            $table->unsignedInteger('module_id');
            $table->foreign('module_id')
            ->references('id')
            ->on('modules')
            ->onDelete('cascade');
            
            $table->unsignedInteger('permission_id');
            $table->foreign('permission_id')
            ->references('id')
            ->on('permissions')
            ->onDelete('cascade');
        });

        Artisan::call('update:permissions');
    }
    
    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        
        Schema::dropIfExists('modules');
        Schema::dropIfExists('module_permission');
        
        Schema::enableForeignKeyConstraints();
    }
}
