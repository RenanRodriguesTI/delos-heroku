<?php

use \Delos\Dgp\Validators\Custom\NotValidDateToRegister;

class DateLimitToRegisterTest extends TestCase
{
    public function testDateIsInvalid()
    {
        // Arrange = Preparar
        $validator = (new NotValidDateToRegister());

        // Act = Agir
        $validation = $validator->validate(null, '22/01/2017', null, null);

        // Arrange = Validar
        $this->assertFalse($validation);
    }

    public function testDateIsInvalidPastYear()
    {
        // Arrange = Preparar
        $validator = (new NotValidDateToRegister());

        // Act = Agir
        $validation = $validator->validate(null, '22/02/2016', null, null);

        // Arrange = Validar
        $this->assertFalse($validation);
    }

    public function testDateIsValid()
    {
        // Arrange = Preparar
        $validator = (new NotValidDateToRegister());
        $yesterday = \Carbon\Carbon::yesterday()->format('d/m/Y');

        // Act = Agir
        $validation = $validator->validate(null, $yesterday, null, null);

        // Arrange = Validar
        $this->assertTrue($validation);
    }
}