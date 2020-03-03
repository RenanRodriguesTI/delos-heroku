<?php

namespace Delos\Dgp\Presenters;

use Delos\Dgp\Transformers\MissingActivityTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MissingActivityPresenter
 *
 * @package namespace Delos\Dgp\Presenters;
 */
class MissingActivityPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MissingActivityTransformer();
    }
}
