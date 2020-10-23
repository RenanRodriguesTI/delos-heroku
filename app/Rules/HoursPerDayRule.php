<?php

namespace Delos\Dgp\Rules;

use Illuminate\Contracts\Validation\Rule;
use Delos\Dgp\Services\WorkingDay;
use Carbon\Carbon;

class HoursPerDayRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    private $data;
    public function __construct(array $data =[])
    {
        if(count($data) ==0){
            $data['start'] = Carbon::now();
            $data['finish'] = Carbon::now();
        }
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
        $maximuHours= 24;
        $hours =  ceil($value / $this->countWorkDays($this->data));

        
        return $maximuHours >= $hours;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Pode ser definido no máximo 24 horas por dia.';
    }


    private function countWorkDays(array $data): int
    {
        $quantity   = 0;
        $diffInDays = $this->getDateRange($data['start'], $data['finish']);
        foreach ($diffInDays as $day) {
            if ($this->isWorkingDay($day)) {
                $quantity++;
            }
        }
        return $quantity;
    }
}
