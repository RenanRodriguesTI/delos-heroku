<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 20/07/17
 * Time: 16:02
 */

namespace Delos\Dgp\Services;

use Delos\Dgp\Repositories\Eloquent\GroupCompanyRepositoryEloquent;
use Prettus\Validator\Contracts\ValidatorInterface;

class GroupCompanyService extends AbstractService
{
    public function repositoryClass(): string
    {
        return GroupCompanyRepositoryEloquent::class;
    }

    public function create(array $data)
    {
        $this->validator->with($data)
            ->passesOrFail(ValidatorInterface::RULE_CREATE);

        $newGroupCompany = $this->repository->create($data);

        session(['groupCompanies' => $this->repository->pluck('id')->toArray()]);

        return $newGroupCompany;
    }
}