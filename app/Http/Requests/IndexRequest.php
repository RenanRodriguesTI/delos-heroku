<?php

namespace Delos\Dgp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'projects.*' => 'exists:projects,id',
            'period' => 'date_format: d/m/Y - d/m/Y'
        ];
    }
}
