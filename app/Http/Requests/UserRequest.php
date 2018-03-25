<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        
        $isNeedToCheckNewPassword = !empty($this->get('old_password'))?'|different:old_password':'';
    
        return [
            'user_id'        => 'sometimes',
            'username'  => "sometimes|required|unique:users,username,".$this->get('user_id')."|max:25|min:6|regex:/^\S*$/",
            'phone'     => 'sometimes|required|min:8|numeric',
            'address'   => 'sometimes|required|max:250|min:15',
            'old_password' => 'sometimes|required|validateOldPassword:'.$this->get('user_id'),
            'password'  => "sometimes|required|max:50|min:6".$isNeedToCheckNewPassword,
            'confirm_password' => 'sometimes|required|same:password',
        ];
    }
    
}
