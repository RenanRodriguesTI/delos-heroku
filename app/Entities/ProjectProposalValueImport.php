<?php

namespace Delos\Dgp\Entities;
use Delos\Dgp\Entities\ProjectProposalValue;
use Maatwebsite\Excel\Concerns\ToModel;

class ProjectProposalValueImport implements ToModel
{

    public function model(array $row)
    {
        return new ProjectProposalValue([
            'month' => $row[0],
        ]);
    }
}

