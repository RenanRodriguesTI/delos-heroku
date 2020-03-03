<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 07/07/17
 * Time: 11:56
 */

use Delos\Dgp\Entities\Project;
use Delos\Dgp\Entities\ProjectType;
use Delos\Dgp\Entities\Task;
use Delos\Dgp\Services\ProjectTypeService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectTypeServiceTest extends \TestCase
{
    use DatabaseTransactions;

    private function getClass() : ProjectTypeService
    {
        return $this->app[ProjectTypeService::class];
    }

    public function testRemoveTask()
    {
        list($projectType, $task) = $this->getProjectTypeAndTasksAttached();

        $this->assertEquals(1, $projectType->tasks->count());

        $this->getClass()->removeTask($projectType->id, $task->id);

        $this->assertEquals(0, $projectType->tasks()->count());
    }

    public function testRemoveTaskWhenTaskWasBudgeted()
    {
        list($projectType, $task) = $this->getProjectTypeAndTasksAttached();

        $this->createProjectWithTaskAttachedAndBudgeted($projectType, $task);

        try {
            $this->getClass()->removeTask($projectType->id, $task->id);
        }catch (Exception $e) {
            $this->assertEquals('Essa tarefa esta orçada para o(s) projeto(s): 123', $e->getMessage());
        }
    }

    public function testRemoveTaskWhenProjectTypeNotExists() {
        try {
            $this->getClass()->removeTask(9999999,9999999);
        } catch (ModelNotFoundException $e) {
            $this->assertEquals('No query results for model [Delos\Dgp\Entities\ProjectType] 9999999', $e->getMessage());
        }
    }

    private function getProjectTypeAndTasksAttached(): array
    {
        $projectType = factory(ProjectType::class)->create();
        $task = factory(Task::class)->create();
        $projectType->tasks()->attach($task->id);
        return array($projectType, $task);
    }

    private function createProjectWithTaskAttachedAndBudgeted($projectType, $task): void
    {
        $project = factory(Project::class)->create(['project_type_id' => $projectType->id]);
        \DB::table('projects')->where('id', $project->id)->update(['compiled_cod' => '123']);
        $project->tasks()->attach($task->id, ['hour' => 60]);
    }
}