<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 19/04/17
 * Time: 10:27
 */

namespace Delos\Dgp\Validators\Custom;

class NotQuantityTotalHoursPerTask
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $total = 0;

        foreach ($value as $hour) {
            !empty($hour) ? $total += $hour : '';
        }

        return $total <= $validator->getData()[$parameters[0]];
    }
}