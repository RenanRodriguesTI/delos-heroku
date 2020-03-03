<?php

namespace Delos\Dgp\Presenters;

use Delos\Dgp\Transformers\GroupTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class GroupPresenter
 *
 * @package namespace Delos\Dgp\Presenters;
 */
class GroupPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new GroupTransformer();
    }
}
