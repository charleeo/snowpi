<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRestaurantMenuRequest extends FormRequest
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
            'menu_name'=>['required','string','min:2','max:225'],
            'price' =>['required','integer'],
            'promo_price' =>['required','integer'],
            'menu_description'=>['required','string','min:30'],
            "menu_images" =>['required','max:204800'],
            'menu_status' =>['required',Rule::in($this->stausRule())],
            'restaurant_id' =>['required','exists:restaurants,restaurant_guid'],
            'promo_code' =>['nuallable','string'],
        ];
    }

    public function stausRule()
    {
        return ['available','not-available'];
    }
}
