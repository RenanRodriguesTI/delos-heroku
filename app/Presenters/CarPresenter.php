<?php

namespace Delos\Dgp\Presenters;

use Delos\Dgp\Transformers\CarTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CarPresenter
 *
 * @package namespace Delos\Dgp\Presenters;
 */
class CarPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CarTransformer();
    }
}
