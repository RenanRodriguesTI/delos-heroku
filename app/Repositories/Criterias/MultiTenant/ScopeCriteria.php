<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 14/07/17
 * Time: 10:40
 */

namespace Delos\Dgp\Repositories\Criterias\MultiTenant;

use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Auth;

class ScopeCriteria implements CriteriaInterface
{
    private $relationshipWithWay = [
        'company' => '',
        'project' => '.company',
        'request' => '.project.company',
        'user' => '.company',
        'expense' => '.project.company'
    ];

    private $withoutScopeModels = [
        \Delos\Dgp\Entities\GroupCompany::class,
        \Delos\Dgp\Entities\Permission::class,
        \Delos\Dgp\Entities\Plan::class
    ];

    public function apply($model, RepositoryInterface $repository)
    {
        if (!session('companies')) {
            session(['companies' => Auth::user()->groupCompany->companies()->pluck('id')->toArray()]);
        }

        $allRelations = $this->getRelations($model);

        if ($this->hasGroupCompanyRelationShip($allRelations)) {
            return $this->ApplyScopeInGroupCompany($model);
        }

        if ($this->isRestView($model)) {
            $this->mapRelations(['user']);
        }

        foreach ($this->relationshipWithWay as $relationship => $way) {

            if ($this->getIfExist($allRelations, $relationship) !== null && !in_array(get_class($model->getModel()), $this->withoutScopeModels)) {

                $relationship = $this->getIfExist($allRelations, $relationship) . $way;
                $model = $this->applyWhereHasFromRelationship($relationship, $model);

                return $model;
            }
        }

        return $model;
    }

    private function getRelations($model)
    {
        return $model->getModel()->relationships();
    }

    private function getIfExist($relations, $key): ?string
    {
        if (array_key_exists($key, $relations)) {
            return $key;
        }

        if (array_key_exists(str_plural($key), $relations)) {
            return str_plural($key);
        }

        return null;
    }

    private function applyWhereHasFromRelationship($relationship, $model)
    {
        $companies = session('companies');

        return $model->whereHas($relationship, function (Builder $query) use ($companies) {
            $query->whereIn('id', $companies);
        });
    }

    private function mapRelations(array $orders) : void
    {
        $result = [];

        foreach ($orders as $index => $order) {
            if (array_key_exists($order, $this->relationshipWithWay)) {
                $result[$order] = $this->relationshipWithWay[$order];
                unset($this->relationshipWithWay[$order]);
            }
        }

        $result = array_merge($result, $this->relationshipWithWay);
        $this->relationshipWithWay = $result;
    }

    private function isRestView($model): bool
    {
        return get_class($model->getModel()) == 'Delos\Dgp\Entities\Activity' && (str_contains(app('request')->url(), '/rests') || session('commandRest'));
    }

    /**
     * @param $allRelations
     * @return bool
     */
    private function hasGroupCompanyRelationShip($allRelations): bool
    {
        return array_key_exists('groupCompany', $allRelations);
    }

    /**
     * @param $model
     * @return mixed
     */
    private function ApplyScopeInGroupCompany($model)
    {
        $model = $model->whereHas('groupCompany', function (Builder $query) {
            $query->whereIn('id', session('groupCompanies'));
        });

        return $model;
    }
}