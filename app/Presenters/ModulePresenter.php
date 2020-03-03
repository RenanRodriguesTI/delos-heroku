<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 24/08/17
 * Time: 10:26
 */

namespace Delos\Dgp\Presenters;

use Delos\Dgp\Transformers\ModuleTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class ModulePresenter extends FractalPresenter
{
    public function getTransformer()
    {
        return app(ModuleTransformer::class);
    }
}