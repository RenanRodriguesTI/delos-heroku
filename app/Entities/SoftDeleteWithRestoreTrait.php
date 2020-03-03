<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Delos\Dgp\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Description of RestoreTrait
 *
 * @author delos
 */
trait SoftDeleteWithRestoreTrait
{
    use SoftDeletes;

    public function restore()
    {
        if( !is_null($this->getKey()) ) {
            return parent::restore();
        }
    }
}