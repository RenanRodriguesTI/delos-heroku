<?php
use Modelizer\Selenium\SeleniumTestCase;

class SeleniumActivitiesTest extends SeleniumTestCase
{
    private function login()
    {
        return $this->visit('/')
            ->hold(1)
            ->type('administrador@delosservicos.com.br', 'email')
            ->type('E5l2a1i9!', 'password')
            ->press('Entrar');
    }

//    public function testIndex()
//    {
//        $this->login();
//        $this->visit('/activities')
//            ->see('Atividades')
//            ->hold(2)
//            ->submitForm('#search-activities', [
//                'users[]' => 18,
//                'projects[]' => 94,
//                'approved[]' => 1,
//                'tasks[]' => 100
//            ]);
//    }

    public function testCreateActivity()
    {
        $this->login();
        $this->visit('/activities')
            ->hold(2)
            ->byId('btn-create-activity')->click();

        $this->select('project_id', '99-XXX-0117-02 - DELOS - DELOS CONSULTORIA, DELOS SERVIÇOS E SISTEMAS LTDA - Gestão de Treinamento')
            ->select('user_id[]', 'MARTIN SALVATI')
            ->select('task_id', 'REUNIÃO')
            ->type(\Carbon\Carbon::now()->format('d/m/Y'), 'start_date')
            ->type(\Carbon\Carbon::now()->format('d/m/Y'), 'finish_date')
            ->select('place_id','Escritório')
            ->byId('save-modal')->click();
        $this->hold(2)
            ->byId('save-hours')->click();
        $this->see('Atividade foi criado com sucesso')
            ->visit('users/login')
            ->hold(2)
            ->select('user_id', 'MARTIN SALVATI')
            ->byId('btn-login-users')->click();
        $this->visit('/activities')
            ->hold(2)
            ->byId('btn-options-activity-0')->click();
        $this->byId('btn-remove-activity-0')->click();
        $this->see('Atividade foi removido com sucesso');
    }
}