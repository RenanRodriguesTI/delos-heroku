<?php

namespace Delos\Dgp\Rules;

use Illuminate\Contracts\Validation\Rule;
use Delos\Dgp\Entities\OfficeHistory;
use Carbon\Carbon;

class OfficePeriodRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    public $idOffice;
    public $history;

    public function __construct($idOffice,$history=0)
    {
        $this->idOffice = $idOffice;
        $this->history = $history;
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
        $value = Carbon::createFromFormat('d/m/Y',$value)->format('Y-m-d');
        if($this->history == 0){
            $history = OfficeHistory::where('office_id',$this->idOffice)->where(function($query) use($value){
                    $query->where('start','<=',$value)
                        ->where('finish','>=',$value);
            })
            ->get();
        } else{
            $history = OfficeHistory::where('office_id',$this->idOffice)->where(function($query) use($value){
                $query->where('start','<=',$value)
                ->where('finish','>=',$value);
            })
            ->whereNotIn('id',[$this->history])
            ->get();
        }

       return $history->isEmpty();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Essa data não está disponível.';
    }
}
