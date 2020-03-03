<?php

namespace Delos\Dgp\Presenters;

use Delos\Dgp\Transformers\AirportTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AirportPresenter
 *
 * @package namespace Delos\Dgp\Presenters;
 */
class AirportPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AirportTransformer();
    }
}
