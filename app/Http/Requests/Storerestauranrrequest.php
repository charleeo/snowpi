<?php

namespace App\Http\Requests;

use App\Models\RestaurantOperator;
use App\Models\RestaurantRole;
use Illuminate\Foundation\Http\FormRequest;

class Storerestauranrrequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $pass  = false;
        $user = RestaurantOperator::find(auth()->guard('restaurant_operator')->id());
        if($user->role == RestaurantRole::where('assigned_name','=',RestaurantRole::Roles['super_admin'])->first()->role_id){
            $pass = true;
        }

        return $pass;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            
        ];
    }
}
