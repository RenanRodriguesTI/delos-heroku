<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 19/07/17
 * Time: 17:41
 */

namespace Delos\Dgp\Services;

use Delos\Dgp\Repositories\Contracts\CompanyRepository;

class CompanyService extends AbstractService
{
    public function repositoryClass(): string
    {
        return CompanyRepository::class;
    }
}