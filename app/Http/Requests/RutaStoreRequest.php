<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RutaStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'nombre' => 'required',
            'colonias'=>"required_unless:colonias,[]"
        ];
    }
    public function messages()
    {
        return [
           'name.required' => 'Este campo es obligatorio.',
           'colonias.required_unless' => 'Este campo es obligatorio.',

        ];
    }
}
