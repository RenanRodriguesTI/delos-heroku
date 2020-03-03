<?php

namespace Delos\Dgp\Repositories\Criterias\GroupCompany;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class GroupCompanyCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        $groupCompanyIds = session('groupCompanies');

        return $model->whereIn('group_company_id', $groupCompanyIds);
    }

}