<?php

namespace Delos\Dgp\Presenters;

use Delos\Dgp\Transformers\CarTypeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CarTypePresenter
 *
 * @package namespace Delos\Dgp\Presenters;
 */
class CarTypePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CarTypeTransformer();
    }
}
