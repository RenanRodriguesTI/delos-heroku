<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 18/04/18
 * Time: 11:09
 */

namespace Delos\Dgp\Presenters;


use Delos\Dgp\Transformers\AllocationTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AllocationPresenter
 * @package Delos\Dgp\Presenters
 */
class AllocationPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AllocationTransformer();
    }
}