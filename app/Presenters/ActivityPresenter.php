<?php

namespace Delos\Dgp\Presenters;

use Delos\Dgp\Transformers\ActivityTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ActivityPresenter
 *
 * @package namespace Delos\Dgp\Presenters;
 */
class ActivityPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ActivityTransformer();
    }
}
