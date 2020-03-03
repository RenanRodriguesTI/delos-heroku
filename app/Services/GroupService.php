<?php

namespace Delos\Dgp\Services;

use Delos\Dgp\Repositories\Eloquent\GroupRepositoryEloquent;
use Prettus\Validator\Contracts\ValidatorInterface;

class GroupService extends AbstractService
{
    public function repositoryClass() : string
    {
        return GroupRepositoryEloquent::class;
    }

    public function create(array $data)
    {
        $data['cod'] = empty($data['cod']) ? $this->generateCod() : $data['cod'];
        $this->validator->with($data)
            ->passesOrFail(ValidatorInterface::RULE_CREATE);

        return $this->repository->makeModel()->create($data);
    }

    private function getMaxAvailableCod(array $cods) : int
    {
        $maxCod = 0;

        for ($i = 0; 100 > $i; $i++) {
            if (!in_array($i, $cods)) {
                $maxCod = $i;
                break;
            }
        }

        return $maxCod;
    }

    private function throwsExceptionIfMaximumValueHasBeenExhausted(string $cod) : void
    {
        if(strlen($cod) > 2) {
            throw new \RangeException('Maximum value has been exhausted');
        }
    }

    private function getAllCods() : array
    {
        $cods = $this->repository->pluck('cod')
            ->map(function ($value) {
                return (int) $value;
            });

        return $cods->all();
    }

    private function padLeftZero(int $cod) : string
    {
        return str_pad($cod, 2, '0', STR_PAD_LEFT);
    }

    private function generateCod() : string
    {
        $cods = $this->getAllCods();

        $maxCod = $this->getMaxAvailableCod($cods);

        $this->throwsExceptionIfMaximumValueHasBeenExhausted($maxCod);
        return $this->padLeftZero($maxCod);
    }
}