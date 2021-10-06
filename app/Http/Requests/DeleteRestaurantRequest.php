<?php

namespace App\Http\Requests;

use App\Models\Restaurant;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DeleteRestaurantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::guard('restaurant_operator_api')->user();
        $pass = false;
        if($this->restaurant_guid){
         $restaurant = Restaurant::where(['restaurant_guid'=>$this->restaurant_guid])->first();
         if( $restaurant  && $restaurant->restaurant_operator_id === $user->id) $pass = true;
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
            //
        ];
    }

    protected function failedAuthorization()
    {
        throw new AuthorizationException('You are not authorized to delete this record');
    }
}
