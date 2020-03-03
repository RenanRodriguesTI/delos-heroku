<?php

use Modelizer\Selenium\SeleniumTestCase;

class SeleniumUsersTest extends SeleniumTestCase
{
    private function login()
    {
        return $this->visit('/')
            ->hold(1)
            ->type('administrador@delosservicos.com.br', 'email')
            ->type('E5l2a1i9!', 'password')
            ->press('Entrar');
    }

    public function testCrud()
    {
        $this->login()
            ->hold(2)
            ->visit('/users')
            ->hold(2)
            ->byLinkText('Novo Usuário')->click();
        $this->hold(2)
            ->type('Teste Automatizado', 'name')
            ->type('teste@automatizado.com', 'email')
            ->select('role_id', 'Root')
            ->select('company_id', 'DELOS SERVIÇOS E SISTEMAS')
            ->select('group_company_id', 'Grupo Delos')
            ->byCssSelector('div.text-right > button.btn.btn-dct')->click();
        $this->hold(2)->see('Usuário foi criado com sucesso')
            ->type('Teste Automatizado', 'search')
            ->byCssSelector('div.btn-group > button.btn.btn-default')->click();
        $this->hold(2)
            ->byXPath("(//button[@type='button'])[10]")->click();
        $this->click('btn-edit-users-0')
            ->hold(2)
            ->type('Teste', 'name')
            ->byCssSelector('div.text-right > button.btn.btn-dct')->click();
        $this->see('Usuário foi editado com sucesso')
            ->hold(2)
            ->click('btn-options-users-0');

        $id = 'http://localhost:8000/users/' . app(\Delos\Dgp\Repositories\Contracts\UserRepository::class)->all()->last()->id . '/destroy';

        $this->click($id)
            ->click('btn-confirm-exclude')
            ->see('Usuário foi removido com sucesso');

        \DB::table('users')->orderBy('id', 'dec')->limit(1)->delete();
    }
}