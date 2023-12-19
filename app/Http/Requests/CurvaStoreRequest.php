<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurvaStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'nombre' => 'required|unique:curvas',
        ];
    }
    public function messages()
    {
        return [
           // 'name.required' => 'Nombre es obligatorio.',

        ];
    }
}
