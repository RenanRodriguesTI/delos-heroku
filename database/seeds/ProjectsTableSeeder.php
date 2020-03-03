<?php

use Faker\Generator;
use Illuminate\Database\Seeder;
use Delos\Dgp\Entities\Project;
use Illuminate\Support\Facades\DB;

class ProjectsTableSeeder extends Seeder
{
    /**
     * @var Generator
     */
    private $faker;

    public function __construct(Generator $faker)
    {

        $this->faker = $faker;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = $this->getAllGroupsId();

        for ($i = 0; $i < 10; $i++) {
            $project = factory(Project::class)->create();
            $this->addLeadersAsMembers($project);

            $hasAnyClient = false;

            do {
                $groupId = $this->faker->randomElement($groups);

                $clients = $this->getClientsIdByGroupId($groupId);

                if (count($clients) > 0) {
                    $hasAnyClient = true;

                    $project->clients()->attach($this->randomElements($clients));

                }

            } while (!$hasAnyClient);
            
            $project = $project->fresh();
            $project->save();
        }
    }

    private function getAllGroupsId() : array
    {
        $groupsId = DB::table('groups')
            ->select()
            ->pluck('id')
            ->toArray();

        return $groupsId;
    }

    private function getClientsIdByGroupId(int $groupId) : array
    {
        $clientsIds = DB::table('clients')
            ->select()
            ->where('group_id', $groupId)
            ->pluck('id')
            ->toArray();

        return $clientsIds;
    }

    private function randomElements(array $elements) : array
    {
        $count = random_int(1, count($elements));

        $selectedElements = $this->faker->randomElements($elements, $count);

        return $selectedElements;
    }

    private function addLeadersAsMembers(Project $project)
    {
        $leaders = [];

        array_push($leaders, $project->owner->id);

        if(!is_null($project->coOwner)) {
            array_push($leaders, $project->coOwner->id);
        }

        $project->members()->attach($leaders);
    }

}
