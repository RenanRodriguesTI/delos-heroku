<?php

    namespace Tests\Browser;

    use Carbon\Carbon;
    use Laravel\Dusk\Browser;
    use Tests\DuskTestCase;

    class RequestTest extends DuskTestCase
    {
        /**
         * Test create Request with all possible resources
         *
         * @return void
         * @group requests
         * @throws \Throwable
         */
        public function testCreateRequestWithAllResources()
        {
            $past7DaysFromNow = Carbon::now()
                                      ->addDays(7)
                                      ->format('d/m/Y');
            $now              = Carbon::now()
                                      ->format('d/m/Y');
            list($collaboratorRole, $managerRole, $roles) = $this->getRolesForWriteTest();

            foreach ( $roles as $email => $password ) {

                $this->loginAndRunBrowser(function (Browser $browser) use ($past7DaysFromNow, $now) {
                    //            Vai até a tela de criação da solicitação
                    $browser->visit('/requests?deleted_at=whereNull')
                            ->pause(1000)
                            ->assertSee('Solicitações')
                            ->click('#btn-create-request')
                            ->pause(1000)
                            ->check('tickets')
                            ->check('lodgings')
                            ->check('cars')
                            ->check('extras')
                            ->press('ENVIAR')
                            ->pause(1000)
                            ->assertSee('Nova Solicitação')
                            ->assertSee('Passagem')
                            ->assertSee('Hospedagem')
                            ->assertSee('Carros')
                            ->assertSee('Extras');

                    //          Preenche o formulário na parte da solicitação
                    $browser->click('#start')
                            ->click('#finish')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->pause(3000)
                            ->click("button[data-id='project_id']")
                            ->click('.project-group ul.dropdown-menu li:first-child a')
                            ->pause(2500)
                            ->click("button[data-id='collaborators']")
                            ->click('.collaborators-group ul.dropdown-menu li:first-child a')
                            ->type('request[notes]', 'Solicitação criado pelo Laravel Dusk');

                    //          Preenche o formulário na parte da passagem
                    $browser->driver->executeScript('window.scrollTo(0, 500);');
                    $browser->pause(1000)
                            ->click('#going_arrival_date')
                            ->click("td[data-day='{$now}']")
                            ->click('#back_arrival_date')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->click('#going_arrival_time')
                            ->click('#back_arrival_time')
                            ->click("button[data-id='going_from_airport_id']")
                            ->click('.going-from-airport-group ul.dropdown-menu li:first-child a')
                            ->click("button[data-id='going_to_airport_id']")
                            ->click('.going-to-airport-id-group ul.dropdown-menu li:first-child a')
                            ->check('ticket[has_preview]')
                            ->check('ticket[client_pay]');

                    //          Preenche o formulário na parte da hospedagem
                    $browser->driver->executeScript('window.scrollTo(0, 1000);');
                    $browser->pause(1000)
                            ->click('#check_in')
                            ->click("td[data-day='{$now}']")
                            ->click('#checkout')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->click("button[data-id='state_id']")
                            ->click('.state-group ul.dropdown-menu li:first-child a')
                            ->pause(2500)
                            ->click("button[data-id='city_id']")
                            ->click('.city-group ul.dropdown-menu li:first-child a')
                            ->click("button[data-id='hotel_room_id']")
                            ->click('.hotel-room-id-group ul.dropdown-menu li:first-child a')
                            ->type('lodging[suggestion]', 'Solicitação criado pelo Laravel Dusk')
                            ->check('lodging[client_pay]');

                    //          Preenche o formulário na parte da Carros
                    $browser->driver->executeScript('window.scrollTo(0, 1500);');
                    $browser->pause(1000)
                            ->click("button[data-id='car_type_id']")
                            ->click('.car-type-id-group ul.dropdown-menu li:first-child a')
                            ->pause(1000)
                            ->click('#withdrawal_date')
                            ->click("td[data-day='{$now}']")
                            ->click('#return_date')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->click('#withdrawal_hour')
                            ->click('#return_hour')
                            ->type('car[withdrawal_place]', 'Solicitação criado pelo Laravel Dusk')
                            ->type('car[return_place]', 'Solicitação criado pelo Laravel Dusk')
                            ->click("button[data-id='first_driver_id']")
                            ->click('.first-driver-id-group ul.dropdown-menu li:first-child a')
                            ->check('car[client_pay]');

                    //          Preenche o formulário na parte da Extras
                    $browser->driver->executeScript('window.scrollTo(0, 2000);');
                    $browser->click('#food_start')
                            ->click("td[data-day='{$now}']")
                            ->click('#food_finish')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->type('extra[taxi][value]', '600,00')
                            ->type('extra[toll][value]', '600,00')
                            ->type('extra[fuel][value]', '600,00')
                            ->type('extra[other][value]', '600,00')
                            ->type('extra[other][description]', 'Solicitação criado pelo Laravel Dusk');

                    //           Clica no botão salvar
                    $browser->press('SALVAR')
                            ->assertSee('Solicitações foi criado com sucesso')
                            ->assertPathIs('/requests');
                }, $email, $password);

                $this->closeAll();
            }

            $this->finishTest($collaboratorRole, $managerRole);
        }

        /**
         * @return array
         */
        private function getRolesForWriteTest(): array
        {
            $collaboratorRole = $this->createUser('123123', 1);
            $managerRole      = $this->createUser('123123', 2);

            $roles = [
                $collaboratorRole->email              => '123123',
                $managerRole->email                   => '123123',
                'administrador@delosservicos.com.br' => '123456',
            ];

            return [$collaboratorRole, $managerRole, $roles];
        }

        /**
         * Test create Request with all possible resources except check boxes
         *
         * @return void
         * @group requests
         * @throws \Throwable
         */
        public function testCreateRequestWithAllResourcesExceptCheckBoxes()
        {
            $past7DaysFromNow = Carbon::now()
                                      ->addDays(7)
                                      ->format('d/m/Y');
            $now              = Carbon::now()
                                      ->format('d/m/Y');
            list($collaboratorRole, $managerRole, $roles) = $this->getRolesForWriteTest();

            foreach ( $roles as $email => $password ) {

                $this->loginAndRunBrowser(function (Browser $browser) use ($past7DaysFromNow, $now) {
                    //            Vai até a tela de criação da solicitação
                    $browser->visit('/requests?deleted_at=whereNull')
                            ->pause(1000)
                            ->assertSee('Solicitações')
                            ->click('#btn-create-request')
                            ->pause(1000)
                            ->check('tickets')
                            ->check('lodgings')
                            ->check('cars')
                            ->check('extras')
                            ->press('ENVIAR')
                            ->pause(1000)
                            ->assertSee('Nova Solicitação')
                            ->assertSee('Passagem')
                            ->assertSee('Hospedagem')
                            ->assertSee('Carros')
                            ->assertSee('Extras');

                    //          Preenche o formulário na parte da solicitação
                    $browser->click('#start')
                            ->click('#finish')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->pause(3000)
                            ->click("button[data-id='project_id']")
                            ->click('.project-group ul.dropdown-menu li:first-child a')
                            ->pause(2500)
                            ->click("button[data-id='collaborators']")
                            ->click('.collaborators-group ul.dropdown-menu li:first-child a')
                            ->type('request[notes]', 'Solicitação criado pelo Laravel Dusk');

                    //          Preenche o formulário na parte da passagem
                    $browser->driver->executeScript('window.scrollTo(0, 500);');
                    $browser->pause(1000)
                            ->click('#going_arrival_date')
                            ->click("td[data-day='{$now}']")
                            ->click('#back_arrival_date')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->click('#going_arrival_time')
                            ->click('#back_arrival_time')
                            ->click("button[data-id='going_from_airport_id']")
                            ->click('.going-from-airport-group ul.dropdown-menu li:first-child a')
                            ->click("button[data-id='going_to_airport_id']")
                            ->click('.going-to-airport-id-group ul.dropdown-menu li:first-child a');

                    //          Preenche o formulário na parte da hospedagem
                    $browser->driver->executeScript('window.scrollTo(0, 1000);');
                    $browser->pause(1000)
                            ->click('#check_in')
                            ->click("td[data-day='{$now}']")
                            ->click('#checkout')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->click("button[data-id='state_id']")
                            ->click('.state-group ul.dropdown-menu li:first-child a')
                            ->pause(2500)
                            ->click("button[data-id='city_id']")
                            ->click('.city-group ul.dropdown-menu li:first-child a')
                            ->click("button[data-id='hotel_room_id']")
                            ->click('.hotel-room-id-group ul.dropdown-menu li:first-child a')
                            ->type('lodging[suggestion]', 'Solicitação criado pelo Laravel Dusk');

                    //          Preenche o formulário na parte da Carros
                    $browser->driver->executeScript('window.scrollTo(0, 1500);');
                    $browser->pause(1000)
                            ->click("button[data-id='car_type_id']")
                            ->click('.car-type-id-group ul.dropdown-menu li:first-child a')
                            ->pause(1000)
                            ->click('#withdrawal_date')
                            ->click("td[data-day='{$now}']")
                            ->click('#return_date')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->click('#withdrawal_hour')
                            ->click('#return_hour')
                            ->type('car[withdrawal_place]', 'Solicitação criado pelo Laravel Dusk')
                            ->type('car[return_place]', 'Solicitação criado pelo Laravel Dusk')
                            ->click("button[data-id='first_driver_id']")
                            ->click('.first-driver-id-group ul.dropdown-menu li:first-child a');

                    //          Preenche o formulário na parte da Extras
                    $browser->driver->executeScript('window.scrollTo(0, 2000);');
                    $browser->click('#food_start')
                            ->click("td[data-day='{$now}']")
                            ->click('#food_finish')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->type('extra[taxi][value]', '600,00')
                            ->type('extra[toll][value]', '600,00')
                            ->type('extra[fuel][value]', '600,00')
                            ->type('extra[other][value]', '600,00')
                            ->type('extra[other][description]', 'Solicitação criado pelo Laravel Dusk');

                    //           Clica no botão salvar
                    $browser->press('SALVAR')
                            ->assertSee('Solicitações foi criado com sucesso')
                            ->assertPathIs('/requests');
                }, $email, $password);

                $this->closeAll();
            }

            $this->finishTest($collaboratorRole, $managerRole);
        }

        /**
         * Test create Request with request
         *
         * @return void
         * @group requests
         * @throws \Throwable
         */
        public function testCreateRequestWithRequest()
        {
            $past7DaysFromNow = Carbon::now()
                                      ->addDays(7)
                                      ->format('d/m/Y');
            $now              = Carbon::now()
                                      ->format('d/m/Y');
            list($collaboratorRole, $managerRole, $roles) = $this->getRolesForWriteTest();

            foreach ( $roles as $email => $password ) {

                $this->loginAndRunBrowser(function (Browser $browser) use ($past7DaysFromNow, $now) {
                    //            Vai até a tela de criação da solicitação
                    $browser->visit('/requests?deleted_at=whereNull')
                            ->pause(1000)
                            ->assertSee('Solicitações')
                            ->click('#btn-create-request')
                            ->pause(1000)
                            ->press('ENVIAR')
                            ->pause(1000)
                            ->assertSee('Nova Solicitação');

                    //          Preenche o formulário na parte da solicitação
                    $browser->click('#start')
                            ->click('#finish')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->pause(3000)
                            ->click("button[data-id='project_id']")
                            ->click('.project-group ul.dropdown-menu li:first-child a')
                            ->pause(2500)
                            ->click("button[data-id='collaborators']")
                            ->click('.collaborators-group ul.dropdown-menu li:first-child a')
                            ->type('request[notes]', 'Solicitação criado pelo Laravel Dusk');

                    //           Clica no botão salvar
                    $browser->press('SALVAR')
                            ->assertSee('Solicitações foi criado com sucesso')
                            ->assertPathIs('/requests');
                }, $email, $password);

                $this->closeAll();
            }

            $this->finishTest($collaboratorRole, $managerRole);
        }

        /**
         * Test create Request with ticket
         *
         * @return void
         * @group requests
         * @throws \Throwable
         */
        public function testCreateRequestWithTicket()
        {
            $past7DaysFromNow = Carbon::now()
                                      ->addDays(7)
                                      ->format('d/m/Y');
            $now              = Carbon::now()
                                      ->format('d/m/Y');
            list($collaboratorRole, $managerRole, $roles) = $this->getRolesForWriteTest();

            foreach ( $roles as $email => $password ) {

                $this->loginAndRunBrowser(function (Browser $browser) use ($past7DaysFromNow, $now) {
                    //            Vai até a tela de criação da solicitação
                    $browser->visit('/requests?deleted_at=whereNull')
                            ->pause(1000)
                            ->assertSee('Solicitações')
                            ->click('#btn-create-request')
                            ->pause(1000)
                            ->check('tickets')
                            ->press('ENVIAR')
                            ->pause(1000)
                            ->assertSee('Nova Solicitação')
                            ->assertSee('Passagem');

                    //          Preenche o formulário na parte da solicitação
                    $browser->click('#start')
                            ->click('#finish')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->pause(3000)
                            ->click("button[data-id='project_id']")
                            ->click('.project-group ul.dropdown-menu li:first-child a')
                            ->pause(2500)
                            ->click("button[data-id='collaborators']")
                            ->click('.collaborators-group ul.dropdown-menu li:first-child a')
                            ->type('request[notes]', 'Solicitação criado pelo Laravel Dusk');

                    //          Preenche o formulário na parte da passagem
                    $browser->driver->executeScript('window.scrollTo(0, 500);');
                    $browser->pause(1000)
                            ->click('#going_arrival_date')
                            ->click("td[data-day='{$now}']")
                            ->click('#back_arrival_date')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->click('#going_arrival_time')
                            ->click('#back_arrival_time')
                            ->click("button[data-id='going_from_airport_id']")
                            ->click('.going-from-airport-group ul.dropdown-menu li:first-child a')
                            ->click("button[data-id='going_to_airport_id']")
                            ->click('.going-to-airport-id-group ul.dropdown-menu li:first-child a')
                            ->check('ticket[has_preview]')
                            ->check('ticket[client_pay]');

                    //           Clica no botão salvar
                    $browser->press('SALVAR')
                            ->assertSee('Solicitações foi criado com sucesso')
                            ->assertPathIs('/requests');
                }, $email, $password);

                $this->closeAll();
            }

            $this->finishTest($collaboratorRole, $managerRole);
        }

        /**
         * Test create Request with ticket except checkboxes
         *
         * @return void
         * @group requests
         * @throws \Throwable
         */
        public function testCreateRequestWithTicketExceptCheckboxes()
        {
            $past7DaysFromNow = Carbon::now()
                                      ->addDays(7)
                                      ->format('d/m/Y');
            $now              = Carbon::now()
                                      ->format('d/m/Y');
            list($collaboratorRole, $managerRole, $roles) = $this->getRolesForWriteTest();

            foreach ( $roles as $email => $password ) {

                $this->loginAndRunBrowser(function (Browser $browser) use ($past7DaysFromNow, $now) {
                    //            Vai até a tela de criação da solicitação
                    $browser->visit('/requests?deleted_at=whereNull')
                            ->pause(1000)
                            ->assertSee('Solicitações')
                            ->click('#btn-create-request')
                            ->pause(1000)
                            ->check('tickets')
                            ->press('ENVIAR')
                            ->pause(1000)
                            ->assertSee('Nova Solicitação')
                            ->assertSee('Passagem');

                    //          Preenche o formulário na parte da solicitação
                    $browser->click('#start')
                            ->click('#finish')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->pause(3000)
                            ->click("button[data-id='project_id']")
                            ->click('.project-group ul.dropdown-menu li:first-child a')
                            ->pause(2500)
                            ->click("button[data-id='collaborators']")
                            ->click('.collaborators-group ul.dropdown-menu li:first-child a')
                            ->type('request[notes]', 'Solicitação criado pelo Laravel Dusk');

                    //          Preenche o formulário na parte da passagem
                    $browser->driver->executeScript('window.scrollTo(0, 500);');
                    $browser->pause(1000)
                            ->click('#going_arrival_date')
                            ->click("td[data-day='{$now}']")
                            ->click('#back_arrival_date')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->click('#going_arrival_time')
                            ->click('#back_arrival_time')
                            ->click("button[data-id='going_from_airport_id']")
                            ->click('.going-from-airport-group ul.dropdown-menu li:first-child a')
                            ->click("button[data-id='going_to_airport_id']")
                            ->click('.going-to-airport-id-group ul.dropdown-menu li:first-child a');

                    //           Clica no botão salvar
                    $browser->press('SALVAR')
                            ->assertSee('Solicitações foi criado com sucesso')
                            ->assertPathIs('/requests');
                }, $email, $password);

                $this->closeAll();
            }

            $this->finishTest($collaboratorRole, $managerRole);
        }

        /**
         * Test create Request with lodging
         *
         * @return void
         * @group requests
         * @throws \Throwable
         */
        public function testCreateRequestWithLodging()
        {
            $past7DaysFromNow = Carbon::now()
                                      ->addDays(7)
                                      ->format('d/m/Y');
            $now              = Carbon::now()
                                      ->format('d/m/Y');
            list($collaboratorRole, $managerRole, $roles) = $this->getRolesForWriteTest();

            foreach ( $roles as $email => $password ) {

                $this->loginAndRunBrowser(function (Browser $browser) use ($past7DaysFromNow, $now) {
                    //            Vai até a tela de criação da solicitação
                    $browser->visit('/requests?deleted_at=whereNull')
                            ->pause(1000)
                            ->assertSee('Solicitações')
                            ->click('#btn-create-request')
                            ->pause(1000)
                            ->check('lodgings')
                            ->press('ENVIAR')
                            ->pause(1000)
                            ->assertSee('Nova Solicitação')
                            ->assertSee('Hospedagem');

                    //          Preenche o formulário na parte da solicitação
                    $browser->click('#start')
                            ->click('#finish')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->pause(3000)
                            ->click("button[data-id='project_id']")
                            ->click('.project-group ul.dropdown-menu li:first-child a')
                            ->pause(2500)
                            ->click("button[data-id='collaborators']")
                            ->click('.collaborators-group ul.dropdown-menu li:first-child a')
                            ->type('request[notes]', 'Solicitação criado pelo Laravel Dusk');

                    //          Preenche o formulário na parte da hospedagem
                    $browser->driver->executeScript('window.scrollTo(0, 1000);');
                    $browser->pause(1000)
                            ->click('#check_in')
                            ->click("td[data-day='{$now}']")
                            ->click('#checkout')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->click("button[data-id='state_id']")
                            ->click('.state-group ul.dropdown-menu li:first-child a')
                            ->pause(2500)
                            ->click("button[data-id='city_id']")
                            ->click('.city-group ul.dropdown-menu li:first-child a')
                            ->click("button[data-id='hotel_room_id']")
                            ->click('.hotel-room-id-group ul.dropdown-menu li:first-child a')
                            ->type('lodging[suggestion]', 'Solicitação criado pelo Laravel Dusk')
                            ->check('lodging[client_pay]');

                    //           Clica no botão salvar
                    $browser->press('SALVAR')
                            ->assertSee('Solicitações foi criado com sucesso')
                            ->assertPathIs('/requests');
                }, $email, $password);

                $this->closeAll();
            }

            $this->finishTest($collaboratorRole, $managerRole);
        }

        /**
         * Test create Request with lodging except checkboxes
         *
         * @return void
         * @group requests
         * @throws \Throwable
         */
        public function testCreateRequestWithLodgingExceptCheckBoxes()
        {
            $past7DaysFromNow = Carbon::now()
                                      ->addDays(7)
                                      ->format('d/m/Y');
            $now              = Carbon::now()
                                      ->format('d/m/Y');
            list($collaboratorRole, $managerRole, $roles) = $this->getRolesForWriteTest();

            foreach ( $roles as $email => $password ) {

                $this->loginAndRunBrowser(function (Browser $browser) use ($past7DaysFromNow, $now) {
                    //            Vai até a tela de criação da solicitação
                    $browser->visit('/requests?deleted_at=whereNull')
                            ->pause(1000)
                            ->assertSee('Solicitações')
                            ->click('#btn-create-request')
                            ->pause(1000)
                            ->check('lodgings')
                            ->press('ENVIAR')
                            ->pause(1000)
                            ->assertSee('Nova Solicitação')
                            ->assertSee('Hospedagem');

                    //          Preenche o formulário na parte da solicitação
                    $browser->click('#start')
                            ->click('#finish')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->pause(3000)
                            ->click("button[data-id='project_id']")
                            ->click('.project-group ul.dropdown-menu li:first-child a')
                            ->pause(2500)
                            ->click("button[data-id='collaborators']")
                            ->click('.collaborators-group ul.dropdown-menu li:first-child a')
                            ->type('request[notes]', 'Solicitação criado pelo Laravel Dusk');

                    //          Preenche o formulário na parte da hospedagem
                    $browser->driver->executeScript('window.scrollTo(0, 1000);');
                    $browser->pause(1000)
                            ->click('#check_in')
                            ->click("td[data-day='{$now}']")
                            ->click('#checkout')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->click("button[data-id='state_id']")
                            ->click('.state-group ul.dropdown-menu li:first-child a')
                            ->pause(2500)
                            ->click("button[data-id='city_id']")
                            ->click('.city-group ul.dropdown-menu li:first-child a')
                            ->click("button[data-id='hotel_room_id']")
                            ->click('.hotel-room-id-group ul.dropdown-menu li:first-child a')
                            ->type('lodging[suggestion]', 'Solicitação criado pelo Laravel Dusk');

                    //           Clica no botão salvar
                    $browser->press('SALVAR')
                            ->assertSee('Solicitações foi criado com sucesso')
                            ->assertPathIs('/requests');
                }, $email, $password);

                $this->closeAll();
            }

            $this->finishTest($collaboratorRole, $managerRole);
        }

        /**
         * Test create Request with car
         *
         * @return void
         * @group requests
         * @throws \Throwable
         */
        public function testCreateRequestWithCar()
        {
            $past7DaysFromNow = Carbon::now()
                                      ->addDays(7)
                                      ->format('d/m/Y');
            $now              = Carbon::now()
                                      ->format('d/m/Y');
            list($collaboratorRole, $managerRole, $roles) = $this->getRolesForWriteTest();

            foreach ( $roles as $email => $password ) {

                $this->loginAndRunBrowser(function (Browser $browser) use ($past7DaysFromNow, $now) {
                    //            Vai até a tela de criação da solicitação
                    $browser->visit('/requests?deleted_at=whereNull')
                            ->pause(1000)
                            ->assertSee('Solicitações')
                            ->click('#btn-create-request')
                            ->pause(1000)
                            ->check('cars')
                            ->press('ENVIAR')
                            ->pause(1000)
                            ->assertSee('Nova Solicitação')
                            ->assertSee('Carros');

                    //          Preenche o formulário na parte da solicitação
                    $browser->click('#start')
                            ->click('#finish')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->pause(3000)
                            ->click("button[data-id='project_id']")
                            ->click('.project-group ul.dropdown-menu li:first-child a')
                            ->pause(2500)
                            ->click("button[data-id='collaborators']")
                            ->click('.collaborators-group ul.dropdown-menu li:first-child a')
                            ->type('request[notes]', 'Solicitação criado pelo Laravel Dusk');

                    //          Preenche o formulário na parte da Carros
                    $browser->pause(1000)
                            ->click("button[data-id='car_type_id']")
                            ->click('.car-type-id-group ul.dropdown-menu li:first-child a')
                            ->pause(1000)->driver->executeScript('window.scrollTo(0, 2000);');

                    $browser->click('#withdrawal_date')
                            ->click("td[data-day='{$now}']")
                            ->click('#return_date')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->click('#withdrawal_hour')
                            ->click('#return_hour')
                            ->type('car[withdrawal_place]', 'Solicitação criado pelo Laravel Dusk')
                            ->type('car[return_place]', 'Solicitação criado pelo Laravel Dusk')
                            ->click("button[data-id='first_driver_id']")
                            ->click('.first-driver-id-group ul.dropdown-menu li:first-child a')
                            ->check('car[client_pay]');

                    //           Clica no botão salvar
                    $browser->press('SALVAR')
                            ->assertSee('Solicitações foi criado com sucesso')
                            ->assertPathIs('/requests');
                }, $email, $password);

                $this->closeAll();
            }

            $this->finishTest($collaboratorRole, $managerRole);
        }

        /**
         * Test create Request with car except checkboxes
         *
         * @return void
         * @group requests
         * @throws \Throwable
         */
        public function testCreateRequestWithCarExceptCheckBoxes()
        {
            $past7DaysFromNow = Carbon::now()
                                      ->addDays(7)
                                      ->format('d/m/Y');
            $now              = Carbon::now()
                                      ->format('d/m/Y');
            list($collaboratorRole, $managerRole, $roles) = $this->getRolesForWriteTest();

            foreach ( $roles as $email => $password ) {

                $this->loginAndRunBrowser(function (Browser $browser) use ($past7DaysFromNow, $now) {
                    //            Vai até a tela de criação da solicitação
                    $browser->visit('/requests?deleted_at=whereNull')
                            ->pause(1000)
                            ->assertSee('Solicitações')
                            ->click('#btn-create-request')
                            ->pause(1000)
                            ->check('cars')
                            ->press('ENVIAR')
                            ->pause(1000)
                            ->assertSee('Nova Solicitação')
                            ->assertSee('Carros');

                    //          Preenche o formulário na parte da solicitação
                    $browser->click('#start')
                            ->click('#finish')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->pause(3000)
                            ->click("button[data-id='project_id']")
                            ->click('.project-group ul.dropdown-menu li:first-child a')
                            ->pause(2500)
                            ->click("button[data-id='collaborators']")
                            ->click('.collaborators-group ul.dropdown-menu li:first-child a')
                            ->type('request[notes]', 'Solicitação criado pelo Laravel Dusk');

                    //          Preenche o formulário na parte da Carros
                    $browser->pause(1000)
                            ->click("button[data-id='car_type_id']")
                            ->click('.car-type-id-group ul.dropdown-menu li:first-child a')
                            ->pause(1000)->driver->executeScript('window.scrollTo(0, 2000);');

                    $browser->click('#withdrawal_date')
                            ->click("td[data-day='{$now}']")
                            ->click('#return_date')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->click('#withdrawal_hour')
                            ->click('#return_hour')
                            ->type('car[withdrawal_place]', 'Solicitação criado pelo Laravel Dusk')
                            ->type('car[return_place]', 'Solicitação criado pelo Laravel Dusk')
                            ->click("button[data-id='first_driver_id']")
                            ->click('.first-driver-id-group ul.dropdown-menu li:first-child a');

                    //           Clica no botão salvar
                    $browser->press('SALVAR')
                            ->assertSee('Solicitações foi criado com sucesso')
                            ->assertPathIs('/requests');
                }, $email, $password);

                $this->closeAll();
            }

            $this->finishTest($collaboratorRole, $managerRole);
        }

        /**
         * Test create Request with all possible extra
         *
         * @return void
         * @group requests
         * @throws \Throwable
         */
        public function testCreateRequestWithExtra()
        {
            $past7DaysFromNow = Carbon::now()
                                      ->addDays(7)
                                      ->format('d/m/Y');
            $now              = Carbon::now()
                                      ->format('d/m/Y');
            list($collaboratorRole, $managerRole, $roles) = $this->getRolesForWriteTest();

            foreach ( $roles as $email => $password ) {

                $this->loginAndRunBrowser(function (Browser $browser) use ($past7DaysFromNow, $now) {
                    //            Vai até a tela de criação da solicitação
                    $browser->visit('/requests?deleted_at=whereNull')
                            ->pause(1000)
                            ->assertSee('Solicitações')
                            ->click('#btn-create-request')
                            ->pause(1000)
                            ->check('extras')
                            ->press('ENVIAR')
                            ->pause(1000)
                            ->assertSee('Nova Solicitação')
                            ->assertSee('Extras');

                    //          Preenche o formulário na parte da solicitação
                    $browser->click('#start')
                            ->click('#finish')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->pause(3000)
                            ->click("button[data-id='project_id']")
                            ->click('.project-group ul.dropdown-menu li:first-child a')
                            ->pause(2500)
                            ->click("button[data-id='collaborators']")
                            ->click('.collaborators-group ul.dropdown-menu li:first-child a')
                            ->type('request[notes]', 'Solicitação criado pelo Laravel Dusk');

                    //          Preenche o formulário na parte da Extras
                    $browser->driver->executeScript('window.scrollTo(0, 2000);');
                    $browser->click('#food_start')
                            ->click("td[data-day='{$now}']")
                            ->click('#food_finish')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->type('extra[taxi][value]', '600,00')
                            ->type('extra[toll][value]', '600,00')
                            ->type('extra[fuel][value]', '600,00')
                            ->type('extra[other][value]', '600,00')
                            ->type('extra[other][description]', 'Solicitação criado pelo Laravel Dusk');

                    //           Clica no botão salvar
                    $browser->press('SALVAR')
                            ->assertSee('Solicitações foi criado com sucesso')
                            ->assertPathIs('/requests');
                }, $email, $password);

                $this->closeAll();
            }

            $this->finishTest($collaboratorRole, $managerRole);
        }

        /**
         * Test create Request with all possible extras values except for extra others description
         *
         * @return void
         * @group requests
         * @throws \Throwable
         */
        public function testCreateRequestWithAnErrorInOtherDescription()
        {
            $past7DaysFromNow = Carbon::now()
                                      ->addDays(7)
                                      ->format('d/m/Y');
            $now              = Carbon::now()
                                      ->format('d/m/Y');
            list($collaboratorRole, $managerRole, $roles) = $this->getRolesForWriteTest();

            foreach ( $roles as $email => $password ) {

                $this->loginAndRunBrowser(function (Browser $browser) use ($past7DaysFromNow, $now) {
                    //            Vai até a tela de criação da solicitação
                    $browser->visit('/requests?deleted_at=whereNull')
                            ->pause(1000)
                            ->assertSee('Solicitações')
                            ->click('#btn-create-request')
                            ->pause(1000)
                            ->check('extras')
                            ->press('ENVIAR')
                            ->pause(1000)
                            ->assertSee('Nova Solicitação')
                            ->assertSee('Extras');

                    //          Preenche o formulário na parte da solicitação
                    $browser->click('#start')
                            ->click('#finish')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->pause(4500)
                            ->click("button[data-id='project_id']")
                            ->click('.project-group ul.dropdown-menu li:first-child a')
                            ->pause(2500)
                            ->click("button[data-id='collaborators']")
                            ->click('.collaborators-group ul.dropdown-menu li:first-child a')
                            ->type('request[notes]', 'Solicitação criado pelo Laravel Dusk');

                    //          Preenche o formulário na parte da Extras
                    $browser->driver->executeScript('window.scrollTo(0, 2000);');
                    $browser->click('#food_start')
                            ->click("td[data-day='{$now}']")
                            ->click('#food_finish')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->type('extra[taxi][value]', '600,00')
                            ->type('extra[toll][value]', '600,00')
                            ->type('extra[fuel][value]', '600,00')
                            ->type('extra[other][value]', '600,00');

                    //           Clica no botão salvar
                    $browser->press('SALVAR')
                            ->pause(1000)
                            ->assertDialogOpened('O campo valor(Outros) é obrigatório quando descrição(Outros) está presente.')
                            ->acceptDialog();
                }, $email, $password);

                $this->closeAll();
            }

            $this->finishTest($collaboratorRole, $managerRole);
        }

        /**
         * Test create Request with all possible extras values except for extra others value
         *
         * @return void
         * @group requests
         * @throws \Throwable
         */
        public function testCreateRequestWithAnErrorInOtherValue()
        {
            $past7DaysFromNow = Carbon::now()
                                      ->addDays(7)
                                      ->format('d/m/Y');
            $now              = Carbon::now()
                                      ->format('d/m/Y');
            list($collaboratorRole, $managerRole, $roles) = $this->getRolesForWriteTest();

            foreach ( $roles as $email => $password ) {

                $this->loginAndRunBrowser(function (Browser $browser) use ($past7DaysFromNow, $now) {
                    //            Vai até a tela de criação da solicitação
                    $browser->visit('/requests?deleted_at=whereNull')
                            ->pause(1000)
                            ->assertSee('Solicitações')
                            ->click('#btn-create-request')
                            ->pause(1000)
                            ->check('extras')
                            ->press('ENVIAR')
                            ->pause(1000)
                            ->assertSee('Nova Solicitação')
                            ->assertSee('Extras');

                    //          Preenche o formulário na parte da solicitação
                    $browser->click('#start')
                            ->click('#finish')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->pause(4500)
                            ->click("button[data-id='project_id']")
                            ->click('.project-group ul.dropdown-menu li:first-child a')
                            ->pause(2500)
                            ->click("button[data-id='collaborators']")
                            ->click('.collaborators-group ul.dropdown-menu li:first-child a')
                            ->type('request[notes]', 'Solicitação criado pelo Laravel Dusk');

                    //          Preenche o formulário na parte da Extras
                    $browser->driver->executeScript('window.scrollTo(0, 2000);');
                    $browser->click('#food_start')
                            ->click("td[data-day='{$now}']")
                            ->click('#food_finish')
                            ->click("td[data-day='{$past7DaysFromNow}']")
                            ->type('extra[taxi][value]', '600,00')
                            ->type('extra[toll][value]', '600,00')
                            ->type('extra[fuel][value]', '600,00')
                            ->type('extra[other][description]', 'Solicitação criado pelo Laravel Dusk');

                    //           Clica no botão salvar
                    $browser->press('SALVAR')
                            ->pause(1000)
                            ->assertDialogOpened('O campo descrição(Outros) é obrigatório quando valor(Outros) está presente.')
                            ->acceptDialog();
                }, $email, $password);

                $this->closeAll();
            }

            $this->finishTest($collaboratorRole, $managerRole);
        }
    }