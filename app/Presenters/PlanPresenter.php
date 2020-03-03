<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 22/08/17
 * Time: 15:23
 */

namespace Delos\Dgp\Presenters;

use Delos\Dgp\Transformers\PlanTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class PlanPresenter extends FractalPresenter
{
    public function getTransformer()
    {
        return PlanTransformer::class;
    }
}