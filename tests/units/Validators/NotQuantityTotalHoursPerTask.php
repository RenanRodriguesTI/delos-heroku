<?php

class NotQuantityTotalHoursPerTask extends TestCase
{
    public function testValid()
    {
        $validator = $this->app->make('validator');

        $validation = $validator->make([
            'hours_per_task' => [
                4,5,10,15
            ],
            'budget' => 30
        ], ['hours_per_task' => 'not_more:budget', 'budget' => 'required']);

        $this->assertEquals('A quantidade de horas por tarefa deve ser menor ou igual à orçada.', $validation->messages()->first());
    }
}