<?php

use Carbon\Carbon;
use Delos\Dgp\Entities\Company;
use Delos\Dgp\Entities\FinancialRating;
use Delos\Dgp\Entities\Group;
use Delos\Dgp\Entities\ProjectType;
use Delos\Dgp\Entities\User;
use Delos\Dgp\Http\Controllers\ProjectsController;
use Delos\Dgp\Repositories\Contracts\ProjectRepository;
use Delos\Dgp\Services\ProjectService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\DB;

/**
     * Class ProjectsControllerTest
     */
    class ProjectsControllerTest extends \TestCase
    {
        use WithoutMiddleware;

        public function test_create()
        {
            //            Arrange
            $data       = $this->getRequestData();
            $controller = $this->getController(ProjectRepository::class, ProjectService::class,
                                               ProjectsController::class, $data, 'projects.create', $data, true);

            //            ACT
            /** @var $store \Illuminate\View\View */
            $store   = $controller->store();
            $project = $this->getProjectCreated($data);

            //            Assert
            $this->assertInstanceOf(Illuminate\View\View::class, $store);
            $this->assertEquals('projects.create', $store->getName());
            $this->assertEquals($data['company_id'], $project->company_id);
            $this->assertEquals($data['financial_rating_id'], $project->financial_rating_id);
            $this->assertEquals($data['project_type_id'], $project->project_type_id);
            $this->assertEquals($data['owner_id'], $project->owner_id);
            $this->assertEquals($data['co_owner_id'], $project->co_owner_id);
            $this->assertEquals($data['budget'], $project->budget);
            $this->assertEquals($data['proposal_number'], $project->proposal_number);
            $this->assertEquals(250000.0, $project->proposal_value);
            $this->assertEquals(0.00, $project->extra_expenses);
            $this->assertEquals(Carbon::createFromFormat('d/m/Y', $data['start'])->format('Y-m-d'), $project->start);
            $this->assertEquals(Carbon::createFromFormat('d/m/Y', $data['finish'])->format('Y-m-d'), $project->finish);
            $this->assertEquals($data['notes'], $project->notes);

//            $this->deleteProjectCreated($data);
        }

        /**
         * Get valid data for store method request
         * @return array
         */
        private function getRequestData(): array
        {
            $group = Group::all()->last();

            $requestAttributes = [
                "company_id"          => Company::all()->last()->id,
                "financial_rating_id" => FinancialRating::all()->last()->id,
                "project_type_id"     => ProjectType::all()->last()->id,
                "owner_id"            => User::all()->last()->id,
                "co_owner_id"         => User::all()->first()->id,
                "group_id"            => $group->id,
                "clients"             => [$group->clients->first()->id],
                "budget"              => "100",
                "proposal_number"     => "N/A",
                "proposal_value"      => 250000.0,
                "extra_expenses"      => "0,00",
                "start"               => Carbon::now()->format('d/m/Y'),
                "finish"              => Carbon::now()->addMonth(2)->format('d/m/Y'),
                "notes"               => bcrypt("Projeto teste"),
                "save"                => "",
            ];
            return $requestAttributes;
        }

        /**
         * Get Project created in test
         *
         * @param array $data
         *
         * @return stdClass
         */
        private function getProjectCreated(array $data): stdClass
        {
            $project = DB::table('projects')->where('notes', $data['notes'])->orderBy('id', 'desc')->first();
            return $project;
        }
    }
