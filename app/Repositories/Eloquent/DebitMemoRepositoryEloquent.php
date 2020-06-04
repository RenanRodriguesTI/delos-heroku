<?php
/**
 * Created by PhpStorm.
 * User: delos
 * Date: 10/02/2017
 * Time: 18:17
 */

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Entities\DebitMemo;
use Delos\Dgp\Presenters\DebitMemoPresenter;
use Delos\Dgp\Repositories\Contracts\DebitMemoRepository;
use Delos\Dgp\Repositories\Criterias\DebitMemo\FilterCriteria;
use Delos\Dgp\Repositories\Criterias\DebitMemo\ScopeCriteria;
use Illuminate\Database\Eloquent\Builder;

class DebitMemoRepositoryEloquent extends BaseRepository implements DebitMemoRepository
{
    protected $fieldSearchable = [
      'number' => 'like'
    ];

    public function presenter()
    {
        return DebitMemoPresenter::class;
    }

    public function boot()
    {
        parent::boot();
        $this->pushCriteria(FilterCriteria::class);
        $this->pushCriteria(ScopeCriteria::class);
    }

    public function model()
    {
        return DebitMemo::class;
    }

    public function getAllOpened()
    {
        return $this->model->whereNull('finish_at');
    }

    public function getAllFinished()
    {
        return $this->model->whereNotNull('finish_at');
    }

    public function verifyExistsProjectAttached(int $id)
    {
        $debitMemos = $this->getAllOpened()->get();

        foreach ($debitMemos as $debitMemo) {

            try{
                if ($debitMemo->expenses->first()->project_id == $id)
                {
                    return $debitMemo;
                }
            }catch (\ErrorException $e)
            {
                return null;
            }
        }

        return null;
    }

    public function getAllOpenedAndEmptyRelationships() : iterable
    {
        $debitMemos = $this->getAllOpened()->get();
        $openedAndEmptyRelationships = [];

        foreach ($debitMemos as $debitMemo) {
            if (!$debitMemo->expenses->count() > 0) {
                array_push($openedAndEmptyRelationships, $debitMemo);
            }
        }

        return $openedAndEmptyRelationships;
    }

    public function getLastNumberByCompanyType(string $path, int $id) : int
    {
        return $this->model->where(function (Builder $query) use ($id, $path){
            $query->whereHas($path, function (Builder $query) use ($id) {
                $query->where('id', '=', $id);
            });
        })->orderBy('id', 'desc')->first()->number ?? 0;
    }


    // public function getDebitSupplierAndUser(){

    //     $httpRequest = app('request');
    //     $projectsIds = $httpRequest->input('projects');

    //     if($this->isEligibleInput($projectsIds)){

    //     }

    //     $status = $httpRequest->input('status');

    //     $model = $this->model->whereHas('expenses')->orWhereHas('supplierExpenses');

    //     if (is_numeric($status)) {
    //         switch ($status) {
    //             case 0:
    //                 $model = $model->whereNotNull('finish_at');
    //                 break;
    //             case 1:
    //                 $model = $model->whereNull('finish_at');
    //                 break;
    //         }
    //     }
    //     return $model;
    // }


    private function isEligibleInput($input)
    {
        return is_array($input) && !empty($input);
    }
}