<?php

namespace Delos\Dgp\Repositories\Criterias\Common;

use Carbon\Carbon;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FilterCriteria implements CriteriaInterface
{

    private $request;

    public function __construct()
    {
        $this->request = app('request');
    }

    public function apply($model, RepositoryInterface $repository)
    {
        if($this->hasEligibleProjectsInput()) {

            $model = $model->whereIn('project_id', $this->request->input('projects'));
        }

        if($this->hasEligiblePeriodInput()) {
            $model = $this->addWhereForStartAndFinishField($this->request->input('period'), $model);
        }

        if($this->hasEligibleCollaboratorsInput()) {
            $model = $model->whereHas('users', function ($query) {
                $collaborators = $this->request->input('collaborators');
                $query->whereIn('id', $collaborators);
            });
        }

        return $model;
    }

    private function addWhereForStartAndFinishField(string $dateString, $model)
    {
        $datesString = explode(' - ', $dateString);

        $format = 'd/m/Y';

        $start = Carbon::createFromFormat($format, $datesString[0]);
        $finish = Carbon::createFromFormat($format, $datesString[1]);

        $model = $model->where(function ($query) use($start, $finish) {

            $query->where(function($query) use($start, $finish) {
                $query->whereBetween('start', [$start->toDateString(), $finish->toDateString()]);
            });

            $query->orWhere(function($query) use($start, $finish) {
                $query->whereBetween('finish', [$start->toDateString(), $finish->toDateString()]);
            });

        });

        return $model;
    }

    private function hasEligibleProjectsInput() : bool
    {

        $projects = $this->request->input('projects');

        return is_array($projects) && !empty($projects);
    }

    private function hasEligiblePeriodInput() : bool
    {
        $period = $this->request->input('period');
        return is_string($period) && !empty($period);
    }

    private function hasEligibleCollaboratorsInput() : bool
    {
        $collaborators = $this->request->input('collaborators');
        return is_array($collaborators) && !empty($collaborators);
    }
}