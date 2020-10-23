<?php

namespace Delos\Dgp\Presenters;

use Delos\Dgp\Transformers\EpiTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class EpiPresenter.
 *
 * @package namespace Delos\Dgp\Presenters;
 */
class EpiPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new EpiTransformer();
    }
}
