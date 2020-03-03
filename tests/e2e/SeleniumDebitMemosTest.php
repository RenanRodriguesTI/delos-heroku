<?php

use Delos\Dgp\Entities\DebitMemo;
use Delos\Dgp\Repositories\Contracts\CompanyRepository;
use Delos\Dgp\Repositories\Contracts\DebitMemoRepository;
use Delos\Dgp\Repositories\Contracts\GroupCompanyRepository;
use Delos\Dgp\Repositories\Contracts\ProjectRepository;
use Modelizer\Selenium\SeleniumTestCase;

class SeleniumDebitMemosTest extends SeleniumTestCase
{
    use \Illuminate\Foundation\Testing\DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        session(['groupCompanies' => app(GroupCompanyRepository::class)->pluck('id')->toArray()]);
        session(['companies' => app(CompanyRepository::class)->pluck('id')->toArray()]);
    }

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
        $this->login();
        $this->visit('/debit-memos')
            ->hold(2)
            ->see('Notas de Débito');
    }

    public function testShow()
    {
        $lastDebitMemo = app(DebitMemoRepository::class)->all()->last();
        $this->login();
        $this->visit('/debit-memos')
            ->hold(2)
            ->click('btn-show-debit-memos-0')
            ->see('ND'.$lastDebitMemo->code);
    }

    public function testFinish()
    {
        $debitMemo = factory(DebitMemo::class)->create();
        $request = $this->setRequest($debitMemo->id);
        $id = env('APP_URL') . '/debit-memos/' . $debitMemo->id . '/close';

        $this->testShow();
        $this->hold(2)
            ->byId('btn-options-debit-memos')->click();
            $this->click($id)
            ->hold(2)
            ->click('btn-confirm-exclude')
            ->hold(2)
            ->see('Finalizado');

        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $debitMemo->delete();
        $request->delete();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    private function setRequest($id)
    {
        \DB::table('requests')->insert([
            [
                'project_id' => app(ProjectRepository::class)->all()->last()->id,
                'approved' => true,
                'start' => \Carbon\Carbon::now()->format('Y-m-d'),
                'finish' => \Carbon\Carbon::now()->addYear()->format('Y-m-d'),
                'debit_memo_id' => $id
            ]
        ]);

        return \DB::table('requests')->orderBy('id', 'desc')->limit(1);
    }
}