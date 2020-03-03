<?php

namespace Delos\Dgp\Presenters;

use Delos\Dgp\Transformers\TransportationFacilityTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TransportationFacilityPresenter
 *
 * @package namespace Delos\Dgp\Presenters;
 */
class TransportationFacilityPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TransportationFacilityTransformer();
    }
}
