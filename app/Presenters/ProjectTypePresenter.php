<?php

namespace Delos\Dgp\Presenters;

use Delos\Dgp\Transformers\ProjectTypeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ProjectTypePresenter
 *
 * @package namespace Delos\Dgp\Presenters;
 */
class ProjectTypePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProjectTypeTransformer();
    }
}
