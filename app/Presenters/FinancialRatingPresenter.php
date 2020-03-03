<?php

namespace Delos\Dgp\Presenters;

use Delos\Dgp\Transformers\FinancialRatingTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FinancialRatingPresenter
 *
 * @package namespace Delos\Dgp\Presenters;
 */
class FinancialRatingPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FinancialRatingTransformer();
    }
}
