<?php

namespace Delos\Dgp\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Exception;
use Delos\Dgp\Entities\Contracts;

class StartPeriodRule implements Rule
{
    public $userid;
    public $id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($userid =0,$id =0)
    {
        $this->userid = $userid;
        $this->id = $id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $contracts = DB::select("select * from contracts where STR_TO_DATE(:date ,'%d/%m/%Y')  between start and end and user_id =:id ",['date' =>$value,'id'=>$this->userid]);
        $contracts = array_filter($contracts,function($class){
            return $class->deleted_at == null && $class->id != $this->id;
        });
        return (!$contracts || sizeof($contracts) ==0);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Não está disponivel';
    }
}
