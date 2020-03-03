<?php

namespace Delos\Dgp\Services;

use Carbon\Carbon;
use Delos\Dgp\Entities\Project;
use Delos\Dgp\Repositories\Contracts\ClientRepository;

trait ProjectCodeGenerator
{
    public function generateCodeProject(Project $project)
    {
        $projectYear = $project->start->format('Y');

        $clientsAmount = app(ClientRepository::class)->countByProjectId($project->id);

        if($clientsAmount == 0) {
            throw new \InvalidArgumentException('Cannot generate the project code when no clients');
        }

        if ($clientsAmount == 1) {
            $client = $project->clients->first();
            $cod = $this->getNextClientProjectCode($client->id, $projectYear);
            return $this->codePad($cod);
        }
        
        $groupId = $project->clients()->first()->group->id;
        $cod = $this->getNextGroupProjectCode($groupId, $projectYear);

        return $this->codePad($cod);
    }

    private function getNextClientProjectCode(int $clientId, int $year)
    {
        $year = Carbon::createFromFormat('Y', $year);

        $cod = $this->repository
            ->getLastClientCodeByClientIdAndYear($clientId, $year);

        $cod ++;

        return $cod;
    }

    private function getNextGroupProjectCode(int $groupId, int $year)
    {
        $year = Carbon::createFromFormat('Y', $year);

        $cod = $this->repository
            ->getLastGroupCodeByGroupIdAndYear($groupId, $year);

        $cod ++;

        return $cod;
    }

    private function codePad(string $code) : string
    {
        return str_pad($code, 2, '0', STR_PAD_LEFT);
    }
}

