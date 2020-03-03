<?php

use Delos\Dgp\Entities\Module;
use Delos\Dgp\Entities\Plan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateRelationshipModulesPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_plan', function (Blueprint $table) {
            $table->unsignedInteger('module_id');
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');

            $table->unsignedInteger('plan_id');
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
        });

        $datas = [
            ['module_id' => $this->getModuleId('Controle de Atividades feitas no Projeto, para levantamento de horas trabalhadas'), 'plan_id' => $this->getPlanId('Caburé')],
            ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'plan_id' => $this->getPlanId('Caburé')],
            ['module_id' => $this->getModuleId('Controle de Tarefas para Atividades'), 'plan_id' => $this->getPlanId('Caburé')],
            ['module_id' => $this->getModuleId('Controle de Tipos de Projeto para melhor classificar os serviços prestados'), 'plan_id' => $this->getPlanId('Caburé')],
            ['module_id' => $this->getModuleId('Controle de Folgas'), 'plan_id' => $this->getPlanId('Caburé')],
            ['module_id' => $this->getModuleId('Gerenciamento de Grupos de Clientes'), 'plan_id' => $this->getPlanId('Caburé')],
            ['module_id' => $this->getModuleId('Gerenciamento de Clientes'), 'plan_id' => $this->getPlanId('Caburé')],
            ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'plan_id' => $this->getPlanId('Caburé')],
            ['module_id' => $this->getModuleId('Gerenciamento Multi Empresas'), 'plan_id' => $this->getPlanId('Caburé')],
            ['module_id' => $this->getModuleId('Controle através de Classificações Financeiras'), 'plan_id' => $this->getPlanId('Caburé')],
            ['module_id' => $this->getModuleId('Controle de Atividades feitas no Projeto, para levantamento de horas trabalhadas'), 'plan_id' => $this->getPlanId('Aluco')],
            ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'plan_id' => $this->getPlanId('Aluco')],
            ['module_id' => $this->getModuleId('Controle de Tarefas para Atividades'), 'plan_id' => $this->getPlanId('Aluco')],
            ['module_id' => $this->getModuleId('Controle de Tipos de Projeto para melhor classificar os serviços prestados'), 'plan_id' => $this->getPlanId('Aluco')],
            ['module_id' => $this->getModuleId('Controle de Despesas'), 'plan_id' => $this->getPlanId('Aluco')],
            ['module_id' => $this->getModuleId('Controle de Folgas'), 'plan_id' => $this->getPlanId('Aluco')],
            ['module_id' => $this->getModuleId('Controle de Notas de Débito gerada através das Despesas'), 'plan_id' => $this->getPlanId('Aluco')],
            ['module_id' => $this->getModuleId('Gerenciamento de Grupos de Clientes'), 'plan_id' => $this->getPlanId('Aluco')],
            ['module_id' => $this->getModuleId('Gerenciamento de Clientes'), 'plan_id' => $this->getPlanId('Aluco')],
            ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'plan_id' => $this->getPlanId('Aluco')],
            ['module_id' => $this->getModuleId('Gerenciamento Multi Empresas'), 'plan_id' => $this->getPlanId('Aluco')],
            ['module_id' => $this->getModuleId('Controle através de Classificações Financeiras'), 'plan_id' => $this->getPlanId('Aluco')],
            ['module_id' => $this->getModuleId('Controle de Atividades feitas no Projeto, para levantamento de horas trabalhadas'), 'plan_id' => $this->getPlanId('Jacurutu')],
            ['module_id' => $this->getModuleId('Gerenciamento de Projetos'), 'plan_id' => $this->getPlanId('Jacurutu')],
            ['module_id' => $this->getModuleId('Controle de Tarefas para Atividades'), 'plan_id' => $this->getPlanId('Jacurutu')],
            ['module_id' => $this->getModuleId('Controle de Tipos de Projeto para melhor classificar os serviços prestados'), 'plan_id' => $this->getPlanId('Jacurutu')],
            ['module_id' => $this->getModuleId('Controle de Despesas'), 'plan_id' => $this->getPlanId('Jacurutu')],
            ['module_id' => $this->getModuleId('Controle de Folgas'), 'plan_id' => $this->getPlanId('Jacurutu')],
            ['module_id' => $this->getModuleId('Controle de Notas de Débito gerada através das Despesas'), 'plan_id' => $this->getPlanId('Jacurutu')],
            ['module_id' => $this->getModuleId('Gerenciamento de Grupos de Clientes'), 'plan_id' => $this->getPlanId('Jacurutu')],
            ['module_id' => $this->getModuleId('Gerenciamento de Clientes'), 'plan_id' => $this->getPlanId('Jacurutu')],
            ['module_id' => $this->getModuleId('Gerenciamento de usuários do sistema'), 'plan_id' => $this->getPlanId('Jacurutu')],
            ['module_id' => $this->getModuleId('Controle de Solicitações para prestação de serviço, tais como Passagem, Hospedagem, Táxi etc.'), 'plan_id' => $this->getPlanId('Jacurutu')],
            ['module_id' => $this->getModuleId('Gerenciamento Multi Empresas'), 'plan_id' => $this->getPlanId('Jacurutu')],
            ['module_id' => $this->getModuleId('Controle através de Classificações Financeiras'), 'plan_id' => $this->getPlanId('Jacurutu')],
        ];

        foreach ($datas as $data) {
            \DB::transaction(function () use ($data){
                \DB::table('module_plan')->insert($data);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('module_plan');

        Schema::enableForeignKeyConstraints();
    }

    private function getModuleId(string $name): int
    {
        return Module::where('name', $name)->first()->id;
    }

    private function getPlanId(string $name): int
    {
        return Plan::where('name', $name)->first()->id;
    }
}
