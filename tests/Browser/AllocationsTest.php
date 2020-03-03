<?php

namespace Tests\Browser;

use Carbon\Carbon;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AllocationsTest extends DuskTestCase
{
    
    /**
    * Teste para criação de uma nova alocação
    *
    * @return void
    * @group allocations
    */
    public function testCreateAllocation()
    {
        $past7DaysFromNow = Carbon::now()->addDays(7)->format('d/m/Y');
        $this->LoginAndRunBrowser(function (Browser $browser) use ($past7DaysFromNow) {
            
            //Acessa a página de alocações
            $browser->visit('/allocations')
            ->pause(1000)
            ->assertSee('Alocações')
            ->pause(1000)
            ->click('#btn-create-allocation')
            ->pause(1000)
            ->click("button[data-id='project_id']")
            ->click('.project-group ul.dropdown-menu li:first-child a')
            ->pause(1000)
            ->click("button[data-id='user_id']")
            ->click('.user-group ul.dropdown-menu li:first-child a')
            ->pause(3000)
            ->click("button[data-id='task_id']")
            ->click('.task-group ul.dropdown-menu li:first-child a')
            ->click('#start')
            ->click('#finish')
            ->click("td[data-day='{$past7DaysFromNow}']")
            ->type('hours', '30')
            ->pause(1000);
            
            // Faz a rolagem da página para baixo em 500px para visualização do preenchimento do campo de descrição
            $browser->driver->executeScript('window.scrollTo(0, 500);');
            
            // Função criada para o Dusk poder inserir texto no textarea do editor HTML utilizando o plugin CKeditor
            $this->typeInCKEditor('#cke_description iframe', $browser, 'Alocação Criada pelo Laravel Dusk');
            
            // Clique para salvar e criar uma nova alocação
            $browser->press('SALVAR')
            ->pause(1500)
            ->assertSee('Alocação foi criado com sucesso')
            ->assertPathIs('/allocations');
        });
        
        $this->CloseAll();
    }
    
    /**
    * Teste para criação de uma nova alocação validando o campo de quantidade de horas.
    *
    * @return void
    * @group allocations
    */
    public function testValidationHourAllocation()
    {
        $past7DaysFromNow = Carbon::now()->addDays(7)->format('d/m/Y');
        $this->LoginAndRunBrowser(function (Browser $browser) use ($past7DaysFromNow) {
            
            //Acessa a página de alocações e validando o campo com 200 horas em 7 dias
            $browser->visit('/allocations')
            ->pause(1000)
            ->assertSee('Alocações')
            ->pause(1000)
            ->click('#btn-create-allocation')
            ->pause(1000)
            ->click("button[data-id='project_id']")
            ->click('.project-group ul.dropdown-menu li:first-child a')
            ->pause(1000)
            ->click("button[data-id='user_id']")
            ->click('.user-group ul.dropdown-menu li:first-child a')
            ->pause(3000)
            ->click("button[data-id='task_id']")
            ->click('.task-group ul.dropdown-menu li:first-child a')
            ->click('#start')
            ->click('#finish')
            ->click("td[data-day='{$past7DaysFromNow}']")
            ->type('hours', '200')
            ->pause(1000);
            
            // Faz a rolagem da página para baixo em 500px para visualização do preenchimento do campo de descrição
            $browser->driver->executeScript('window.scrollTo(0, 500);');
            
            // Função criada para o Dusk poder inserir texto no textarea do editor HTML utilizando o plugin CKeditor
            $this->typeInCKEditor('#cke_description iframe', $browser, 'Alocação Criada pelo Laravel Dusk');
            
            // Clique para salvar e criar uma nova alocação
            $browser->press('SALVAR')
            ->pause(1500)
            ->assertSee('Quantidade de horas não deve ser maior que 192.')
            ->assertPathIs('/allocations/create');
        });
        
        $this->CloseAll();
    }
    
    /**
    * Teste para visualização das alocações.
    *
    * @return void
    * @group allocations
    */
    public function testShowAllocation()
    {
        $past7DaysFromNow = Carbon::now()->addDays(7)->format('d/m/Y');
        
        $this->LoginAndRunBrowser(function (Browser $browser) use ($past7DaysFromNow) {
            
            // Acessa a página de detalhes da última alocação criada e verifica o botão para voltar para agenda de alocações
            $browser->visit("allocations")
            ->pause(1000)
            ->assertSee('Alocações')
            ->click('.fc-body a:first-child')
            ->pause(2000);
        });
        
        $this->CloseAll();
    }
    
    /**
    * Teste para exclusão das alocações
    *
    * @return void
    * @group allocations
    */
    public function testDeleteAllocation()
    {
        $past7DaysFromNow = Carbon::now()->addDays(7)->format('d/m/Y');
        $this->LoginAndRunBrowser(function (Browser $browser) use ($past7DaysFromNow) {
            
            // Acessa a página de deta2lhes e faz o teste de exclusão da última alocação criada pelo teste do Dusk
            $browser->visit("allocations")
            ->pause(1000)
            ->assertSee('Alocações')
            ->click('.fc-body a:first-child')
            ->pause(1000)
            ->clickLink('Excluir')
            ->pause(1000)
            ->type('reason', 'Exclusão Criada pelo Laravel Dusk')
            ->pause(2000)
            ->press('REMOVER')
            ->pause(1500)
            ->assertSee('Alocação foi removido com sucesso')
            ->assertPathIs('/allocations');
        });
        
        $this->CloseAll();
    }
}
