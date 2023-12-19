<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CotizacionStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [

            'user_id' => 'required',
            'cliente_id' => 'required',
            'codigo' => 'required',
            'productos' => 'required',
           /* 'metodos_pago.*.metodo_pago_id' => 'required',
            'metodos_pago.*.monto' => 'required',*/

        ];

    }

    public function messages()
    {
        return [
             'cliente_id.required' => 'Cliente es obligatorio.',
            // 'metodos_pago.*.required' => 'Metodo de pago es obligatorio.',
             'productos.required' => 'Debe Seleccionar un producto',


        ];
    }
}
