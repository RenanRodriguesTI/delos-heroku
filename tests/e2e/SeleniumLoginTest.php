<?php
use Modelizer\Selenium\SeleniumTestCase;

class SeleniumLoginTest extends SeleniumTestCase
{
    public function testLoginForm()
    {
        $this->visit('/')
            ->hold(2)
            ->seePageIs('/auth/login')
            ->see('Login')
            ->type('administrador@delosservicos.com.br', 'email')
            ->type('E5l2a1i9!', 'password')
            ->press('Entrar')
            ->seePageIs('/')
            ->see('Administrador');
    }

    public function testRestPassword()
    {
        $this->visit('/password/reset')
            ->see('Redefinir senha')
            ->submitForm('.form-horizontal', ['email' => 'administrador@delosservicos.com.br']);

            $this->see('Nós enviamos um e-mail com um link para redefinição de sua senha!');

    }

    public function testChangePass()
    {
        $this->testLoginForm();
        $this->visit('users/change-pass')
            ->see('Alterar a senha')
            ->submitForm('#change-pass-form', [
                'password' => 'E5l2a1i9!',
                'password_confirmation' => 'E5l2a1i9!'
            ])
            ->see('Senha alterada com sucesso');
    }
}