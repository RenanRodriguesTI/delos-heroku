<?php

namespace Delos\Dgp\Rules;

use Illuminate\Contracts\Validation\Rule;

class TelephoneRule implements Rule
{
    public $forceOnlyNumber;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($forceOnlyNumber = false)
    {
        $this->forceOnlyNumber = $forceOnlyNumber;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $phone)
    {
        $regex = '/^(?:(?:\+|00)?(55)\s?)?(?:\(?([1-9][0-9])\)?\s?)?(?:((?:9\d|[2-9])\d{3})\-?(\d{4}))$/';

        if (preg_match($regex, $phone) == false) {

            // O número não foi validado.
            return false;
        } else {

            // Telefone válido.
            return true;
        }        
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute é inválido';
    }
}
