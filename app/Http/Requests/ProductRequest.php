<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'product_name'=>'required|max:50|min:6|',
            'category'=>'required',
            'deskripsi'=> 'required',
            'stock' => 'required|numeric|min:1',
            'purchase'=>'required|numeric|min:1000',
            'sell'=>'required_with:purchase|numeric|greater_than_field:purchase|min:1000',
            'product_image'=>'mimes:png,jpeg,jpg|max:500'
        ];
    }
}
