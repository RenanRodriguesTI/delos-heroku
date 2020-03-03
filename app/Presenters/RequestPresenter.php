<?php

namespace Delos\Dgp\Presenters;

use Delos\Dgp\Transformers\RequestTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class RolePresenter
 *
 * @package namespace Delos\Dgp\Presenters;
 */
class RequestPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RequestTransformer();
    }
}
