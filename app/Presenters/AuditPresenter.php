<?php

namespace Delos\Dgp\Presenters;

use Delos\Dgp\Transformers\AuditTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AuditPresenter
 *
 * @package namespace Delos\Dgp\Presenters;
 */
class AuditPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AuditTransformer();
    }
}
