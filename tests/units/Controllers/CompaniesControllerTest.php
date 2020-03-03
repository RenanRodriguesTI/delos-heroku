<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 20/07/17
 * Time: 10:26
 */

namespace units\Controllers;

use Delos\Dgp\Http\Controllers\CompaniesController;
use Delos\Dgp\Repositories\Contracts\CompanyRepository;
use Delos\Dgp\Services\CompanyService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Pagination\LengthAwarePaginator;

class CompaniesControllerTest extends \TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testResponseIndex()
    {
        $index = $this->getController(CompanyRepository::class, CompanyService::class, CompaniesController::class, [], 'companies.index')->index();

        $this->assertEquals('companies.index', $index->getName());

        $index = $index['companies'];

        $this->assertInstanceOf(LengthAwarePaginator::class, $index);
        $this->assertLessThanOrEqual(10, $index->getCollection()->count());
        foreach ($index->getCollection() as $index => $item) {
            $this->assertEquals(['id', 'name', 'created_at', 'updated_at', 'group_company_id'], array_keys($item->getAttributes()));
        }
    }

    public function testCreate()
    {
        $create = $this->getController(CompanyRepository::class, CompanyService::class, CompaniesController::class, [], 'companies.create')->create();

        $this->assertEquals('companies.create', $create->getName());
    }
}