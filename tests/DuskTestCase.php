<?php

namespace Tests;

    use Carbon\Carbon;
    use Delos\Dgp\Entities\Project;
    use Delos\Dgp\Entities\User;
    use Facebook\WebDriver\Chrome\ChromeOptions;
    use Facebook\WebDriver\Remote\DesiredCapabilities;
    use Facebook\WebDriver\Remote\RemoteWebDriver;
    use Illuminate\Foundation\Testing\WithFaker;
    use Laravel\Dusk\Browser;
    use Laravel\Dusk\TestCase as BaseTestCase;

    abstract class DuskTestCase extends BaseTestCase
    {
        use CreatesApplication, WithFaker;

        /**
         * Prepare for Dusk test execution.
         *
         * @beforeClass
         * @return void
         */
        public static function prepare()
        {
            static::startChromeDriver();
        }

        /**
         * Create the RemoteWebDriver instance.
         *
         * @return \Facebook\WebDriver\Remote\RemoteWebDriver
         */
        protected function driver()
        {
            $options = (new ChromeOptions())->addArguments(['start-maximized']);

            return RemoteWebDriver::create('http://localhost:9515', DesiredCapabilities::chrome()
                                                                                       ->setCapability(ChromeOptions::CAPABILITY, $options));
        }

        /**
         * Run login and continue with browser tests
         *
         * @param \Closure $closure
         * @param string   $email
         * @param string   $password
         *
         * @throws \Throwable
         */
        protected function loginAndRunBrowser(\Closure $closure, string $email = 'administrador@delosservicos.com.br', string $password = 'E5l2a1i9!')
        {
            $this->browse(function (Browser $browser) use ($closure, $email, $password) {
                $login = $browser->visit('/')
                ->pause(2000)
                ->type('email', $email)
                ->type('password', $password)
                ->press('ENTRAR')
                ->pause(2000);

                $closure($login);
            });
        }


        public function typeInCKEditor ($selector, $browser, string $text)
        {
            $ckIframe = $browser->elements($selector)[0];
            $browser->driver->switchTo()->frame($ckIframe);
            $body = $browser->driver->findElement(WebDriverBy::xpath('//body'));
            $body->sendKeys($text);
            $browser->driver->switchTo()->defaultContent();
        }
        
        /**
         * @param string $password
         * @param int    $roleId
         *
         * @return User
         */
        protected function createUser(string $password, int $roleId): User
        {
            $now = Carbon::now();
            $this->setUserRootLogged();
            $user = factory(User::class)->create([
                                             'password'         => bcrypt($password),
                                             'role_id'          => $roleId,
                                             'company_id'       => '1',
                                             'group_company_id' => '1'
                                         ]);

            $project = factory(Project::class)->create([
                'start' => $now->format('d/m/Y'),
                'finish' => $now->addMonth()->format('d/m/Y'),
                'company_id'       => '1',
                'owner_id' => $user->id
                                            ]);
            $project->members()->attach($user->id);

            return $user;
        }

        /**
         * @return void
         */
        private function setUserRootLogged()
        {
            $user = User::find(1);
            session(['groupCompanies' => [$user->groupCompany->id]]);
            session([
                        'companies' => $user->groupCompany->companies()
                                                          ->pluck('id')
                                                          ->toArray()
                    ]);
            $this->actingAs($user);
        }

        /**
         * @param $collaboratorRole
         * @param $managerRole
         */
        protected function finishTest($collaboratorRole, $managerRole): void
        {
            $collaboratorRole->forceDelete();
            $managerRole->forceDelete();
        }
    }
