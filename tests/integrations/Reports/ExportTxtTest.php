<?php

use Carbon\Carbon;
use Delos\Dgp\Reports\TxtReportInterface;
use Delos\Dgp\Repositories\Contracts\ExpenseRepository as Repository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TestExportTxt extends TestCase
{
    use DatabaseTransactions;

    public function __call($name, $arguments)
    {
        switch ($name) {
            case 'repository':
                return app(Repository::class);
                break;
            case 'carbon':
                return app(Carbon::class);
                break;
            case 'export':
                return app(TxtReportInterface::class);
                break;
        }
    }

    public function testGenerateContentsInTxt()
    {
        // Arrange = Preparar
        $expense = $this->repository()->create([
            'user_id' => '38',
            'request_id' => '1',
            'invoice' => '1234',
            'issue_date' => '13/06/2017',
            'value' => '35,21',
            'payment_type_id' => '1',
            'description' => 'Almoço',
            'note',
            'original_name' => 'test.png',
            's3_name' => '1.png',
            'exported' => false
        ]);

        // Act = Agir
        $this->export()->generate(collect(['1' => $this->repository()->find($expense->id)]));

        // Arrange = Validar
        $this->assertEquals(\File::get('storage/app/reports/expenses/expenses-test.txt'), \Storage::disk('local')->get('reports/expenses/expenses.txt'));
    }
}