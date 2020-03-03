<?php

    use Delos\Dgp\Http\Controllers\CoastUsersController;
    use Delos\Dgp\Repositories\Contracts\CoastUserRepository;
    use Delos\Dgp\Services\CoastUserService;
    use Illuminate\Foundation\Testing\DatabaseTransactions;
    use Illuminate\Foundation\Testing\WithoutMiddleware;
    use Illuminate\Support\Collection;

    /**
     * Created by PhpStorm.
     * User: allan
     * Date: 01/06/18
     * Time: 15:39
     */
    class CoastUsersControllerTest extends \TestCase
    {
        use WithoutMiddleware, DatabaseTransactions;

        public function test_index()
        {
            //        Arrange
            $controller  = $this->getController(CoastUserRepository::class, CoastUserService::class, CoastUsersController::class, [], 'coast-users.index', []);

            //        ACT
            $index = $controller->index();

            //        Assert
            $this->assertEquals('coast-users.index', $index->getName());
            $this->assertInstanceOf(Collection::class, $index['users']);
            foreach ( $index['users'] as $key => $item ) {
                $this->assertEquals([
                                        "id",
                                        "name",
                                        "email",
                                        "password",
                                        "admission",
                                        "role_id",
                                        "overtime",
                                        "remember_token",
                                        "deleted_at",
                                        "created_at",
                                        "updated_at",
                                        "supplier_number",
                                        "company_id",
                                        "account_number",
                                        "is_partner_business",
                                        "avatar",
                                        "group_company_id",
                                        "notes",
                                    ], array_keys($item->getAttributes()));
            }

            $keys = ['users'];

            foreach ( $keys as $key ) {
                $this->assertArrayHasKey($key, $index->getData());
            }
        }
    }