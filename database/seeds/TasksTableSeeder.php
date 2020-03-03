<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks')->insert([
            ['id' => 1, 'name' =>	'CONCILIAÇÃO'],
            ['id' => 2, 'name' =>	'BALANCETE'],
            ['id' => 3, 'name' =>	'CONFERÊNCIA DE NOTAS'],
            ['id' => 5, 'name' =>	'BANCO DE PREÇOS'],
            ['id' => 6, 'name' =>	'DESLOCAMENTO'],
            ['id' => 7, 'name' =>	'REUNIÃO'],
            ['id' => 8, 'name' =>	'PREPARAÇÃO BASE DE DADOS'],
            ['id' => 9, 'name' =>	'LAUDO'],
            ['id' => 10, 'name' =>	'OUTSOURCING'],
            ['id' => 11, 'name' =>	'ELABORAÇÃO PROCEDIMENTOS'],
            ['id' => 12, 'name' =>	'AUDITORIA'],
            ['id' => 13, 'name' =>	'RELATÓRIO'],
            ['id' => 16, 'name' =>	'PLANEJAMENTO, ACOMPANHAMENTO E SUPERVISÃO'],
            ['id' => 17, 'name' =>	'CADASTRO MEDIDORES E POSTES'],
            ['id' => 18, 'name' =>	'SEM ATIVIDADE'],
            ['id' => 19, 'name' =>	'AVALIAÇÃO'],
            ['id' => 21, 'name' =>	'REVISÃO DE INVENTÁRIO'],
            ['id' => 77, 'name' =>	'AVALIAÇÃO CIVIL'],
            ['id' => 78, 'name' =>	'AVALIAÇÃO MÁQUINAS, EQUIPAMENTOS, MÓVEIS E UTENSÍLIOS'],
            ['id' => 79, 'name' =>	'REVISÃO INVENTÁRIO ESCRITÓRIO'],
            ['id' => 80, 'name' =>	'FISCALIZAÇÃO'],
            ['id' => 81, 'name' =>	'UNITIZAÇÃO'],
            ['id' => 82, 'name' =>	'APROVAÇÃO DO TCR'],
            ['id' => 83, 'name' =>	'ANALISE DO TCR'],
            ['id' => 84, 'name' =>	'INVENTÁRIO'],
            ['id' => 87, 'name' =>	'MANUTENÇÃO'],
            ['id' => 89, 'name' =>	'CARGA SISTEMA'],
            ['id' => 90, 'name' =>	'EXTRAÇÃO DE BASE DE DADOS'],
            ['id' => 91, 'name' =>	'FOLGA'],
            ['id' => 92, 'name' =>	'FÉRIAS'],
            ['id' => 93, 'name' =>	'CRIAÇÃO DE BASE DE DADOS'],
            ['id' => 95, 'name' =>	'PAP - PLANEJAMENTO DE ALOCAÇÃO EM PROJETOS'],
            ['id' => 99, 'name' =>	'AGUARDANDO ATIVIDADES'],
            ['id' => 100, 'name' =>	'CONSULTA MÉDICA'],
            ['id' => 101, 'name' =>	'AJUSTES DO RAF'],
            ['id' => 102, 'name' =>	'ANALISE DE BASE FISICA'],
            ['id' => 103, 'name' =>	'DOCUMENTAÇÃO FOTOGRÁFICA'],
            ['id' => 104, 'name' =>	'NR-10'],
            ['id' => 105, 'name' =>	'FALTA'],
            ['id' => 106, 'name' =>	'BASE BLINDADA'],
            ['id' => 107, 'name' =>	'TREINAMENTO'],
            ['id' => 108, 'name' =>	'VISTORIA'],
            ['id' => 109, 'name' =>	'ADMINISTRAÇÃO DGA'],
            ['id' => 110, 'name' =>	'ATUALIZAÇÃO PLANO DE CONTAS ANEEL'],
            ['id' => 111, 'name' =>	'PRECIFICAÇÃO'],
            ['id' => 112, 'name' =>	'ANÁLISE COM E CA'],
            ['id' => 113, 'name' =>	'ANÁLISE SOBRA FÍSICA'],
            ['id' => 114, 'name' =>	'ANÁLISE IA'],
            ['id' => 115, 'name' =>	'ANÁLISE OE'],
            ['id' => 116, 'name' =>	'REVISÃO AVALIAÇÃO CIVIL'],
            ['id' => 117, 'name' =>	'CLASSIFICAÇÃO DO RAZÃO'],
            ['id' => 118, 'name' =>	'DE-PARA CONTAS ANEEL'],
            ['id' => 121, 'name' =>	'NOVA BASE INCREMENTAL'],
            ['id' => 123, 'name' =>	'SUPORTE'],
            ['id' => 124, 'name' =>	'COBRANZA'],
            ['id' => 125, 'name' =>	'CONFERÊNCIA LANÇAMENTOS'],
            ['id' => 126, 'name' =>	'ANÁLISE E VALIDAÇÃO DAS INFORMAÇÕES INICIAIS'],
            ['id' => 127, 'name' =>	'ANÁLISE E VALIDAÇÃO DAS INFORMAÇÕES REENCAMINHADAS'],
            ['id' => 128, 'name' =>	'ANÁLISE DA MOVIMENTAÇÃO CONTÁBIL '],
            ['id' => 129, 'name' =>	'PREPARAÇÃO DE TREINAMENTO'],
            ['id' => 130, 'name' =>	'ESTUDO'],
            ['id' => 131, 'name' =>	'VALIDAÇÃO'],
            ['id' => 132, 'name' =>	'DESENVOLVIMENTO DE SOFTWARES'],
            ['id' => 133, 'name' =>	'VINCULAÇÃO FÍSICO X LAUDO DE AVALIAÇÃO'],
            ['id' => 134, 'name' =>	'APRESENTAÇÃO'],
            ['id' => 135, 'name' =>	'RESOLUÇÃO 396'],
            ['id' => 136, 'name' =>	'BASE FÍSICA'],
            ['id' => 137, 'name' =>	'BASE CONTÁBIL'],
            ['id' => 138, 'name' =>	'GERAÇÃO DO RCP'],
            ['id' => 139, 'name' =>	'AFASTAMENTO'],
            ['id' => 140, 'name' =>	'BASE INCREMENTAL'],
            ['id' => 141, 'name' =>	'COORDENAÇÃO DE TCR´S'],
            ['id' => 142, 'name' =>	'ALMOXARIFADO DE OPERAÇÃO'],
            ['id' => 143, 'name' =>	'ANÁLISE'],
            ['id' => 144, 'name' =>	'RESPOSTA SDI'],
            ['id' => 145, 'name' =>	'DESCANSO'],
            ['id' => 146, 'name' =>	'ATIVO IMOBILIZADO'],
            ['id' => 147, 'name' =>	'LAUDO PRÉVIO'],
            ['id' => 148, 'name' =>	'COMPRAR FOLGA'],
            ['id' => 149, 'name' =>	'COMPRAR FÉRIAS'],
            ['id' => 150, 'name' =>	'AUSÊNCIA'],
        ]);
    }
}