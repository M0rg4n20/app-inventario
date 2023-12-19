<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PesoStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'codigo' => 'required|unique:pesos|max:3',
            'nombre' => 'required|unique:pesos',
        ];
    }
    public function messages()
    {
        return [
           // 'name.required' => 'Nombre es obligatorio.',

        ];
    }
}
