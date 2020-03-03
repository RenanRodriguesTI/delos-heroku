<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 24/08/17
 * Time: 10:34
 */

namespace Delos\Dgp\Transformers;

use Delos\Dgp\Entities\Module;
use League\Fractal\TransformerAbstract;

class ModuleTransformer extends TransformerAbstract
{
    public function transform(Module $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'permissions' => $model->permissions->implode('name', ', ')
        ];
    }
}