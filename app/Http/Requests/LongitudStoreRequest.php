<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LongitudStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'codigo' => 'required|unique:longitudes|max:3',
            'nombre' => 'required|unique:longitudes',
        ];
    }
    public function messages()
    {
        return [
           // 'name.required' => 'Nombre es obligatorio.',

        ];
    }
}
