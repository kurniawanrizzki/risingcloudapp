<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'category_name'=> 'required|max:50|min:6|',
            'category_img' => 'mimes:png,jpeg,jpg|max:500',
            'category_description'  => 'required|max:300|min:15'
        ];
    }
}
