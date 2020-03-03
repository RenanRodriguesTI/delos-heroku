<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Entities\Company;
use Delos\Dgp\Repositories\Contracts\CompanyRepository;
use Delos\Dgp\Repositories\Contracts\UserRepository;
use Illuminate\Support\Collection;

class CompanyRepositoryEloquent extends BaseRepository implements CompanyRepository
{
    public function model()
    {
        return Company::class;
    }

    public function getPairs(bool $withOutPartnerBusiness = true)
    {
        $result =  $this->pluck('name', 'id');
        $usersArePartnerBusiness = app(UserRepository::class)->findWhere(['is_partner_business' => true]);

        if ($usersArePartnerBusiness->count() > 0 && $withOutPartnerBusiness) {
            $this->setCompaniesFromPartnerBusiness($result, $usersArePartnerBusiness);
        }

        return $result->sort()->all();
    }

    private function setCompaniesFromPartnerBusiness(Collection &$result, Collection $users) : void
    {
        foreach ($users as $user) {
            $result->put($user->company->id . " - partner_business", $user->company->name . " - SÓCIOS");
        }
    }
}