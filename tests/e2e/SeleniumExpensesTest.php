<?php

use Delos\Dgp\Entities\Expense;
use Delos\Dgp\Repositories\Contracts\CompanyRepository;
use Delos\Dgp\Repositories\Contracts\GroupCompanyRepository;
use Delos\Dgp\Repositories\Contracts\ProjectRepository;
use Modelizer\Selenium\SeleniumTestCase;

class SeleniumExpensesTest extends SeleniumTestCase
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
        $this->login()
            ->visit('/expenses')
            ->submitForm('#form-search-expenses', [
                'search' => 'RECIBO'
            ]);
    }

    public function testCreate()
    {
        list($request, $text) = $this->getRequest();

        $this->login()
            ->visit('/expenses')
            ->hold(2)
            ->click('btn-create-expense')
            ->hold(2)
            ->submitForm('#form-expenses', [
                'issue_date_calendar' => \Carbon\Carbon::now()->format('d/m/Y'),
                'request_id' => $text,
                'user_id' => 1,
                'invoice' => 123,
                'invoice_file' => $this->file(public_path(). '/images/bg_login.jpg'),
                'value' => 25.50,
                'payment_type_id' => 'dinheiro',
                'description' => 'Almoço'
            ])
            ->hold(3)
            ->see('Despesa foi criado com sucesso');

        $request->delete();
    }

    public function testDelete()
    {
        $expense = factory(Expense::class)->create();
        $id = env('APP_URL') . '/expenses/' . $expense->id . '/destroy';
        $this->login();
        $this->visit('/expenses')
            ->hold('2')
            ->byId('btn-options-expense-0')->click();
        $this->byId($id)->click();
        $this->hold(1)
            ->byId('btn-confirm-exclude')->click();
        $this->hold(2)
            ->see('Despesa foi removido com sucesso');
    }

    public function testEdit()
    {
        $this->login();
        $this->visit('/expenses')
            ->hold(2)
            ->byId('btn-options-expense-0')->click();
        $this->byId('btn-edit-expense-0')->click();
        $this->hold(2)
            ->see('Editar Despesa')
            ->submitForm('#form-expenses', [])
            ->hold(2)->see('Despesa foi editado com sucesso');
    }

    private function getRequest(): array
    {
        \DB::table('requests')->insert([
            [
                'project_id' => app(ProjectRepository::class)->all()->last()->id,
                'approved' => true,
                'start' => \Carbon\Carbon::now()->format('Y-m-d'),
                'finish' => \Carbon\Carbon::now()->addYear()->format('Y-m-d')
            ]
        ]);

        $request = \DB::table('requests')->orderBy('id', 'desc')->limit(1);
        \DB::table('request_user')->insert([
            [
                'request_id' => $request->first()->id,
                'user_id' => 1
            ]
        ]);

        $start = \Carbon\Carbon::createFromFormat('Y-m-d', $request->first()->start)->format('d/m/Y');
        $finish = \Carbon\Carbon::createFromFormat('Y-m-d', $request->first()->finish)->format('d/m/Y');
        $text = "Nº: {$request->first()->id} - De: {$start} - Até: {$finish} ";
        return array($request, $text);
    }
}