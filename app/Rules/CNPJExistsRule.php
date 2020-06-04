<?php

namespace Delos\Dgp\Rules;

use Illuminate\Contracts\Validation\Rule;
use Delos\Dgp\Entities\Provider;

class CNPJExistsRule implements Rule
{
    public $id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id=0)
    {
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
        $value =str_replace(['.','/','-'],'',$value);
        $provider = Provider::where('cnpj',$value)->first();
        
        return $provider && $provider->id !=$this->id ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return strtoupper(':attribute').' está em uso';
    }
}
