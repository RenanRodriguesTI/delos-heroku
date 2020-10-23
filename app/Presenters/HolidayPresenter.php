<?php

namespace Delos\Dgp\Presenters;

use Delos\Dgp\Transformers\HolidayTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class HolidayPresenter.
 *
 * @package namespace Delos\Dgp\Presenters;
 */
class HolidayPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new HolidayTransformer();
    }
}
