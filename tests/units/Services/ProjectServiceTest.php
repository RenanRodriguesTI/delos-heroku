<?php

use Delos\Dgp\Services\ProjectService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Created by PhpStorm.
 * User: allan
 * Date: 19/02/18
 * Time: 10:05
 */

class ProjectServiceTest extends \TestCase
{
    use DatabaseTransactions;

    /**
     *  Test the method create with valid data
     */
    public function test_valid_create()
    {
        $data = $this->getValidData();

        $project = $this->getProjectService()->create($data);

        $this->assertInstanceOf(\Delos\Dgp\Entities\Project::class, $project);
    }

    /**
     * Test the method create when exists a invalid data
     */
    public function test_invalid_create()
    {
        $this->expectException(\Prettus\Validator\Exceptions\ValidatorException::class);

        $data = $this->getInvalidData();

        $this->getProjectService()->create($data);
    }

    /**
     * Test for validate the tasks from project type is attached when project is created
     */
    public function test_is_attached_all_tasks_from_project_type()
    {
        $data = $this->getValidData();

        $project = $this->getProjectService()->create($data);

        $this->assertEquals($project->projectType->tasks->pluck('id'), $project->tasks->pluck('id'));
    }

    /**
     * Get ProjectType instance
     * @return ProjectService
     */
    private function getProjectService() {
        return app(ProjectService::class);
    }

    /**
     * Valid data to create a project
     * @return array
     */
    private function getValidData(): array
    {
        $data = [
            "company_id" => "1",
            "financial_rating_id" => "1",
            "project_type_id" => "1",
            "group_id" => "1",
            "clients" => [
                "1"
            ],
            "owner_id" => "2",
            "co_owner_id" => "",
            "budget" => "10000",
            "proposal_number" => "",
            "proposal_value" => "150.00,00",
            "extra_expenses" => "0,00",
            "start" => "19/02/2018",
            "finish" => "19/02/2018"
        ];
        return $data;
    }

    /**
     * Invalid data to create a project
     * @return array
     */
    private function getInvalidData(): array
    {
        $data = [
            "cod" => str_repeat('1', 300),
            "description" => str_repeat('1', 300),
            "company_id" => "999",
            "financial_rating_id" => "1",
            "project_type_id" => "1",
            "group_id" => "1",
            "clients" => [
                "1"
            ],
            "owner_id" => "2",
            "co_owner_id" => "",
            "budget" => "10000",
            "proposal_number" => "",
            "proposal_value" => "150.00,00",
            "extra_expenses" => "0,00",
            "start" => "19/02/2018",
            "finish" => "19/02/2018"
        ];
        return $data;
    }
}