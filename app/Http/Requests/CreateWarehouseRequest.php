<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWarehouseRequest extends FormRequest
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
            "warehouse_name"=>['required','string',"max:225"],
            "warehouse_location"=>['required','string',"max:225"],
            "warehouse_description"=>['required','string'],
            "size"=>['required','string',"max:225"],
            // "state_id"=>['required','integer',"exists:states,id"],
            "id"=>['nullable','integer',"exists:warehouses,id"],
            "region_id"=>['required','integer',"exists:regions,id"],
        ];
    }
}
