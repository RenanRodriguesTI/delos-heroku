<?php
use Modelizer\Selenium\SeleniumTestCase;

class SeleniumMissingActivitiesTest extends SeleniumTestCase
{
    private function login()
    {
        return $this->visit('/')
            ->hold(1)
            ->type('administrador@delosservicos.com.br', 'email')
            ->type('E5l2a1i9!', 'password')
            ->press('Entrar');
    }

    public function testIndex()
    {
        $this->login()->visit('/missing-activities')->see('Atividades Faltantes');
    }
}