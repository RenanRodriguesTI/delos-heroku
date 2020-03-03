<?php

    use Carbon\Carbon;
    use Delos\Dgp\Entities\Allocation;
    use Delos\Dgp\Entities\Project;
    use Delos\Dgp\Http\Controllers\GanttController;
    use Illuminate\Foundation\Testing\WithoutMiddleware;

    /**
     * Class GanttControllerTest
     */
    class GanttControllerTest extends \TestCase
    {
        use WithoutMiddleware;

        /**
         * Test method index projects
         */
        public function test_index_projects()
        {
            //            Arrange
            $projectController = app(GanttController::class);
            $keys              = ['projects', 'projectsToSearch'];

            //            ACT
            $index = $projectController->indexProjects();

            //            Assert
            foreach ( $keys as $key ) {
                $this->assertArrayHasKey($key, $index->getData());
            }
            $this->assertContains('resources/views/reports/ganttProjects.blade.php', $index->getPath());
            $this->assertEquals('reports.ganttProjects', $index->getName());
            $this->assertInstanceOf(\Illuminate\View\View::class, $index);
            $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $index->getData()['projects']);
        }

        /**
         * Test method index projects
         */
        public function test_index_resources()
        {
            //            Arrange
            $projectController = app(GanttController::class);
            $keys              = ['users', 'collaborators'];

            //            ACT
            $index = $projectController->indexResources();

            //            Assert
            foreach ( $keys as $key ) {
                $this->assertArrayHasKey($key, $index->getData());
            }
            $this->assertContains('resources/views/reports/ganttResources.blade.php', $index->getPath());
            $this->assertEquals('reports.ganttResources', $index->getName());
            $this->assertInstanceOf(\Illuminate\View\View::class, $index);
            $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $index->getData()['users']);
        }

    }
