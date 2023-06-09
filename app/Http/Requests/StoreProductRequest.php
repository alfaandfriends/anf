<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
        $rules = [
            'product_name' => 'required',
            'product_description' => 'required',
            'product_price' => 'exclude_if:product_variation,enabled|numeric',
            'product_stock' => 'exclude_if:product_variation,enabled|required',
            'product_category' => 'required',
            'product_cover_image' => 'nullable|image',
            'product_image_1' => 'nullable|image',
            'product_image_2' => 'nullable|image',
            'product_image_3' => 'nullable|image',
            'product_image_4' => 'nullable|image',
            'product_image_5' => 'nullable|image',
            'product_image_6' => 'nullable|image',
            'product_variation' => 'required',
            'product_variation_items' => 'exclude_if:product_variation,disabled|required'
        ];

        if ($this->input('product_variation') === 'enabled') {
            $rules['product_variation_items.*.options.*.price'] = 'numeric';
        }

        return $rules;
    }
}
