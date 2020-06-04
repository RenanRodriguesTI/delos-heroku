<?php

namespace Delos\Dgp\Entities;

use Illuminate\Database\Eloquent\Model;

class VoucherType extends Model
{
    public function expenses(){
        return $this->hasMany(SupplierExpenses::class);
    }
}
