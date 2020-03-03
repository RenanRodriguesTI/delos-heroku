<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 15/02/17
 * Time: 15:15
 */

namespace Delos\Dgp\Presenters;

use Delos\Dgp\Transformers\DebitMemoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class DebitMemoPresenter extends FractalPresenter
{
    public function getTransformer()
    {
        return new DebitMemoTransformer();
    }
}