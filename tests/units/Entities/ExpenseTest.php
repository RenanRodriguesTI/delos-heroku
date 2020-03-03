<?php

use \Delos\Dgp\Entities\Expense;

class ExpenseTest extends TestCase
{
    public function testExpenseStatusIsNonExported()
    {
        // Arrange = Preparar
        $expense = (new Expense([
            'user_id' => '1',
            'request_id' => '1',
            'invoice' => '1234',
            'issue_date' => \Carbon\Carbon::yesterday()->format('d/m/Y'),
            'value' => '35.21',
            'payment_type_id' => '1',
            'description' => 'Almoço',
            'note',
            'original_name' => 'test.png',
            's3_name' => '1.png',
            'exported' => false
        ]));

        // Act = Agir
        $status = $expense->getStatusAttribute();

        // Arrange = Validar
        $this->assertEquals('non-exported', $status);
    }

    public function testExpenseStatusIsExported()
    {
        // Arrange = Preparar
        $expense = (new Expense([
            'user_id' => '1',
            'request_id' => '1',
            'invoice' => '1234',
            'issue_date' => \Carbon\Carbon::yesterday()->format('d/m/Y'),
            'value' => '35.21',
            'payment_type_id' => '1',
            'description' => 'Almoço',
            'note',
            'original_name' => 'test.png',
            's3_name' => '1.png',
            'exported' => true
        ]));

        // Act = Agir
        $status = $expense->getStatusAttribute();

        // Arrange = Validar
        $this->assertEquals('exported', $status);
    }
}