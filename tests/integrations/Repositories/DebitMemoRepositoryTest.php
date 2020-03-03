<?php

use Carbon\Carbon;
use Delos\Dgp\Entities\Project;
use Delos\Dgp\Entities\Request;
use Delos\Dgp\Repositories\Contracts\DebitMemoRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TestDebitMemoRepository extends TestCase
{
    use DatabaseTransactions;

    public function __call($name, $arguments)
    {
        switch ($name) {
            case 'carbon':
                return app(Carbon::class);
                break;
        }
    }

    private function repository()
    {
        return app(DebitMemoRepository::class);
    }

    public function testAllOpenedAndFinished()
    {
        // Arrange = Preparar
        $this->repository()->create([
            'number' => '9999'
        ]);

        $this->repository()->create([
            'number' => '8888',
            'finish_at' => $this->carbon()->yesterday()->format('Y-m-d h:i:s')
        ]);


        // Act = Agir
        $opened = $this->repository()->getAllOpened();
        $finished = $this->repository()->getAllFinished();

        // Arrange = Validar
        $this->assertEquals('9999', $opened->get()->last()->number);
        $this->assertEquals('8888', $finished->get()->last()->number);
    }

    public function testVerifyExistsProjectAttached()
    {
        //Arrange = Preparar
        $debitMemo = $this->repository()->create([
            'number' => '9999'
        ]);

        $project = Project::create([
            'cod' => '01',
            'project_type_id' => '1',
            'financial_rating_id' => '2',
            'budget' => '9999',
            'owner_id' => '1',
            'co_owner_id' => null,
            'proposal_value' => '9998,99',
            'proposal_number' => '0011',
            'company_id' => null
        ]);

        Request::create([
            'requester_id' => '38',
            'project_id' => $project->id,
            'parent_id' => null,
            'approved' => false,
            'reason' => null,
            'start' => $this->carbon()->now()->subMonth()->format('Y-m-d'),
            'finish' => $this->carbon()->now()->addDay(5)->format('Y-m-d'),
            'debit_memo_id' => $debitMemo->id
        ]);

        //Act = Agir
        $validationNotNull = $this->repository()->verifyExistsProjectAttached($project->id);
        $validationNull = $this->repository()->verifyExistsProjectAttached(999999999999999);

        //Arrange = Validar
        $this->assertNotNull($validationNotNull);
        $this->assertNull($validationNull);
    }

    public function testGetAllOpenedAndEmptyRelationships()
    {
        //Arrange = Preprar
        $debitMemo = $this->repository()->create([
            'number' => '9999'
        ]);

        //Act = Agir
        $opened = $this->repository()->getAllOpenedAndEmptyRelationships();

        //Arrange = Validar
        $this->assertEquals('9999', end($opened)->number);
    }
}