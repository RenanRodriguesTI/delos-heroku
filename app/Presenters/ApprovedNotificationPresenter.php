<?php

namespace Delos\Dgp\Presenters;

use Delos\Dgp\Transformers\ApprovedNotificationTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ApprovedNotificationPresenter.
 *
 * @package namespace Delos\Dgp\Presenters;
 */
class ApprovedNotificationPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ApprovedNotificationTransformer();
    }
}
