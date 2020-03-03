<?php

use Modelizer\Selenium\SeleniumTestCase;

class SeleniumCompaniesTest extends SeleniumTestCase
{
    private function login()
    {
        return $this->visit('/')
            ->hold(1)
            ->type('administrador@delosservicos.com.br', 'email')
            ->type('E5l2a1i9!', 'password')
            ->press('Entrar');
    }

    public function testCRUD()
    {
        $this->login()
            ->visit('/companies')
            ->hold(2)
            ->byCssSelector('a.btn.btn-dct')->click();
        $this->hold(2)
            ->select('group_company_id', 'Grupo Delos')
            ->type('Teste Automatizado', 'name')
            ->byCssSelector('button[name="save"]')->click();
        $this->hold(2)
            ->see('Empresa foi criado com sucesso')
            ->byXPath('//a[contains(text(),\'Editar\')]')->click();
        $this->hold(2)
            ->type('teste', 'name')
            ->byCssSelector('button[name="save"]')->click();
        $this->hold(2)
            ->see('Empresa foi editado com sucesso');

        \DB::table('companies')->orderBy('id', 'desc')->limit(1)->delete();
    }
}