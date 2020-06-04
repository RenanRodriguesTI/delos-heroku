<?php

namespace Delos\Dgp\Transformers;

use League\Fractal\TransformerAbstract;
use Delos\Dgp\Entities\AppVersion;

class AppVersionTransformer extends TransformerAbstract
{

    public function transform(AppVersion $model)
    {
        return [
            'id' => (int) $model->id,
            'version' => $model->version,
            'important' => $model->important
        ];
    }
}
