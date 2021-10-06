<?php

namespace App\Http\Requests;

use App\Rules\RestaurantOperatorsRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRestaurantOperatorRequest extends FormRequest
{
    protected $stopOnFirstFailure =true;
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
            'name'=>['required','string','min:2','max:225'],
            'email'=>['required','string','min:2','max:225','email','unique:restaurant_operators'],
            'password'=>[
            'required','string','min:8','max:225','confirmed',
            'regex:/[a-z]/',      
            'regex:/[A-Z]/',      
            'regex:/[0-9]/',      
            'regex:/[@$!%*#?|&]/'
            ],
            'role_id'=>['nullable'],
            'operator_type'=>  ['required', Rule::in(['owner','employee'])],
        ];
    }

    public function messages()
    {
     return [
         'password.regex'=> 'The password field must contain an upper case letter, a lower case letter, a numeric value and a special character'
        ];
    }
}
