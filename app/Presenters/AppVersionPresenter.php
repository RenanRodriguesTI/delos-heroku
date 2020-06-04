<?php

namespace Delos\Dgp\Presenters;

use Delos\Dgp\Transformers\AppVersionTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AppVersionPresenter
 *
 * @package namespace Delos\Dgp\Presenters;
 */
class AppVersionPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AppVersionTransformer();
    }
}
