<?php

namespace App\Http\Requests;

use App\Models\RestaurantMenu;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateRestaurantMenuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // $user = Auth::guard('restaurant_operator_api')->user();
        // $pass = false;
        // if($this->menu_guid){
        //  $restaurant = RestaurantMenu::where(['menu_guid'=>$this->menu_guid])->first();
        //  if( $restaurant  && $restaurant->restaurant_operator_id === $user->id) $pass = true;
        // }
        //  return $pass;
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
            "menu_guid" =>['required','string'],
            'menu_status' =>['required',Rule::in($this->statusRule())],
            'restaurant_id' =>['required','exists:restaurants,restaurant_guid'],
            'promo_code' =>['nuallable','string'],
        ];
    }
public static function statusRule()
{
    return ['available','not-available'];

}
}
