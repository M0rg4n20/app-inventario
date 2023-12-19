<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PagoStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [

            'venta_id' => 'required',
            'tipo_pago' => 'required',
            'metodo_pago' => 'required',
            'metodo_pago_id' => 'required',
            'monto_efectivo'=>'required_if:metodo_pago_id,1|required_if:metodo_pago_id,3|nullable',
            'monto_tarjeta'=>'required_if:metodo_pago_id,2|required_if:metodo_pago_id,3',
            'num_tarjeta'=>'required_if:metodo_pago_id,2|required_if:metodo_pago_id,3',

        ];

    }

    public function messages()
    {
        return [
             'metodo_pago.required' => 'Metodo de pago es obligatorio.',
             'venta_id.required' => 'Este campo es obligatorio.',
             'metodo_pago_id.required' => 'Este campo es obligatorio.',
             'tipo_pago.required_if' => 'Este campo es obligatorio.',
             'num_tarjeta.required_if' => 'Este campo es obligatorio.',
             'monto_tarjeta.required_if' => 'Este campo es obligatorio.',
             'monto_efectivo.required_if' => 'Este campo es obligatorio.',



        ];
    }
}
