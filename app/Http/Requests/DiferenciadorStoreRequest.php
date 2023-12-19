<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiferenciadorStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'nombre' => 'required|unique:diferenciadores',
        ];
    }
    public function messages()
    {
        return [
           // 'name.required' => 'Nombre es obligatorio.',

        ];
    }
}
