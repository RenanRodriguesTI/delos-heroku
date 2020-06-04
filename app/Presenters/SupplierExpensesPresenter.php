<?php

namespace Delos\Dgp\Presenters;

use Delos\Dgp\Transformers\SupplierExpensesTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class SupplierExpensesPresenter
 *
 * @package namespace Delos\Dgp\Presenters;
 */
class SupplierExpensesPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SupplierExpensesTransformer();
    }
}
