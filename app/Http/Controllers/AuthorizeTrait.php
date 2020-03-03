<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 16/06/17
 * Time: 12:33
 */

namespace Delos\Dgp\Http\Controllers;

trait AuthorizeTrait
{
    public function getMappedAbilities() : array
    {
        return [
            'store' => 'create',
            'edit' => 'update'
        ];
    }
}