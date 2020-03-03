<?php

namespace Delos\Dgp\Presenters;

use Delos\Dgp\Transformers\PlaceTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PlacePresenter
 *
 * @package namespace Delos\Dgp\Presenters;
 */
class PlacePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PlaceTransformer();
    }
}
