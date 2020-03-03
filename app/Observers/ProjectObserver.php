<?php

namespace Delos\Dgp\Observers;

use Delos\Dgp\Entities\Project;

class ProjectObserver
{
    public function saving(Project $project)
    {
        $project->compiled_cod      = $this->getCompiledCod($project);
        $project->description       = $this->getDescription($project);
    }

    public function deleting(Project $project)
    {
        $project->activities()->delete();
        $project->requests()->delete();
        $project->expenses()->where('exported', true)->delete();
        $project->allocations()->delete();
    }

    public function restoring(Project $project)
    {
        $project->activities()->onlyTrashed()->restore();
        $project->requests()->onlyTrashed()->restore();
        $project->expenses()->where('exported', true)->onlyTrashed()->restore();
        $project->allocations()->onlyTrashed()->restore();
    }

    private function getDescription(Project $project)
    {
        if ( request('description') ) {
            return request('description');
        }

        $description = '';

        $firstClient = $project->clients()->first();

        if(!is_null($firstClient)) {
            $description  = $firstClient->group->name . ' - ';
            $description .= $project->clients->implode('name', ', ') . ' - ';
            $description .= $project->projectType->name;
        }

        return $description;
    }

    private function getCompiledCod(Project $project)
    {
        $compileCod = '';

        $firstClient = $project->clients->first();

        if(!is_null($firstClient)) {
            $compileCod  = $firstClient->group->cod . '-';
            $compileCod .= $project->clients->count() > 1 ? 'XXX' : $firstClient->cod;
            $compileCod .=  "-{$project->cod}{$project->start->format('y')}-{$project->financialRating->cod}";
        }

        return $compileCod;
    }
}