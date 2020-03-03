<?php

namespace Delos\Dgp\Console\Commands;

use Delos\Dgp\Entities\GroupCompany;
use Delos\Dgp\Entities\ProjectType;
use Delos\Dgp\Repositories\Contracts\ProjectRepository;
use Delos\Dgp\Repositories\Contracts\ProjectTypeRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Helper\ProgressBar;

class UpdateTasksFromProjectType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:project-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update tasks of the projects from project type';
    /**
     * @var ProjectTypeRepository
     */
    private $repository;

    /**
     * Create a new command instance.
     *
     * @param ProjectTypeRepository $repository
     */
    public function __construct(ProjectTypeRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $progress = $this->getProgress();
        $progress->start();

        foreach (app(GroupCompany::class)->all() as $groupCompany) {

            session(['groupCompanies' => [$groupCompany->id]]);
            session(['companies' => $groupCompany->companies()->pluck('id')->toArray()]);
            $this->repository
                ->all()
                ->each(function ($projectType, $key) use ($progress) {

                    $projectType->projects->each(function ($project, $key) use ($projectType, $progress) {
                        $tasks = $project->tasks->pluck('id');

                        $tasksToAdd = $this->getTasksId($projectType, $tasks);

                        $project->tasks()->attach($tasksToAdd);

                        $progress->advance();
                    });

                    $progress->advance();
                });
        }

        $progress->finish();
    }

    private function getProgress()
    {
        return new ProgressBar($this->getOutput(), (count($this->repository->makeModel()->all()) + count(app(ProjectRepository::class)->makeModel()->all())));
    }

    private function getTasksId(ProjectType $projectType, Collection $tasks) : array
    {
        $tasksToAdd = $projectType->tasks()
            ->whereNotIn('id', $tasks)
            ->get()
            ->pluck('id');

        $tasks = [];

        foreach ($tasksToAdd as $task) {
            array_push($tasks, $task);
        }

        return $tasks;
    }
}
