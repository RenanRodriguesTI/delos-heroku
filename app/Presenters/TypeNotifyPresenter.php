<?php

namespace Delos\Dgp\Presenters;

use Delos\Dgp\Transformers\TypeNotifyTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TypeNotifyPresenter.
 *
 * @package namespace Delos\Dgp\Presenters;
 */
class TypeNotifyPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TypeNotifyTransformer();
    }
}
