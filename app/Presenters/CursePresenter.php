<?php

namespace Delos\Dgp\Presenters;

use Delos\Dgp\Transformers\CurseTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CursePresenter.
 *
 * @package namespace Delos\Dgp\Presenters;
 */
class CursePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CurseTransformer();
    }
}
