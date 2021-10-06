<?php

namespace App\Http\Requests;

   use App\Models\RestaurantRole;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRestaurantRequest extends FormRequest
{
    public $message;
    protected $stopOnFirstFailure = true;
    public function authorize()
    {
        $pass =false;
        $user = Auth::guard('restaurant_operator_api')->user();
        $roles= RestaurantRole::where(['name'=>RestaurantRole::Roles['super_admin']])->first();
        if($user && $user->role_id == $roles->id) {
            $pass= true;
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
            'name'=>['required','string','min:2','max:225'],
            'address_line_1'=>['required','string','min:10','max:225'],
            'address_line_2'=>['nullable','string','min:10','max:225'],
            'phone_1'=>['required','max:15','min:9'],
            'phone_2'=>['nullable','max:15','min:9'],
            'email_1'=>['required','email'],
            'email_2'=>['nullable','email'],
            'description'=>['nullable','string','min:50'],
            'town_id'=>['required','exists:local_governments,id'],
        ];
    }

    protected function failedAuthorization()
    {
        throw new AuthorizationException('You  are not authorize to edit another persons data');
    }
}
