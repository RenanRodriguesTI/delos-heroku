<?php

namespace Delos\Dgp\Repositories\Contracts;

interface CompanyRepository extends RepositoryInterface
{
    public function getPairs(bool $withOutPartnerBusiness = true);
}