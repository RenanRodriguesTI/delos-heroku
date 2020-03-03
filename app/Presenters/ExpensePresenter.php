<?php

namespace Delos\Dgp\Presenters;

use Delos\Dgp\Transformers\ExpenseTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ExpensePresenter
 *
 * @package namespace Delos\Dgp\Presenters;
 */
class ExpensePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ExpenseTransformer();
    }
}
