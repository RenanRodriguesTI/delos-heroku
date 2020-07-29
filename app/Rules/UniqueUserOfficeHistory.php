<?php

namespace Delos\Dgp\Rules;

use Illuminate\Contracts\Validation\Rule;
use Delos\Dgp\Entities\UserOffice;
use Carbon\Carbon;

class UniqueUserOfficeHistory implements Rule
{

    public $id;
    public $officeId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id,$before,$idoffice)
    {
        $this->id =$id;
        $this->before = $before;
        $this->idoffice = $idoffice;
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
        $userOffice = UserOffice::where('user_id',$this->id)
        ->where('start',Carbon::createFromFormat('d/m/Y',$value)->format('Y-m-d'))->get();

        return $userOffice->isEmpty() || $this->before->id_office == $this->idoffice;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A data não está disponivel.';
    }
}
