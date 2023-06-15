<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'order_customer' => 'required',
            'order_product' => 'required',
            'order_status' => 'required',
            'order_shipping_no' => 'required',
            'order_shipping_provider' => 'required',
        ];
    }
}
