<?php

namespace Delos\Dgp\Presenters;

use Delos\Dgp\Transformers\TaskTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TaskPresenter
 *
 * @package namespace Delos\Dgp\Presenters;
 */
class TaskPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TaskTransformer();
    }
}
