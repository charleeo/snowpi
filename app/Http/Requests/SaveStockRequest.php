<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveStockRequest extends FormRequest
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
            'stock_name'  => ['required','string','max:225','min:1'],
            'stock_image'  => ['nullable','image'],
            'stock_description' =>['nullable','string','min:20'],
            'arrival_date'  => ['required','date_format:Y-m-d'],
            'sold_date' => ['nullable','date_format:Y-m-d'],
            'cost_price'  => ['nullable','numeric'],
            'sales_price'  => ['nullable','numeric'],
            'logistics_cost'  => ['nullable','numeric'],
            'profit'  => ['nullable','numeric'],
            'quntity_received'  => ['nullable','numeric'],
            'quntity_sold'  => ['nullable','numeric'],
            'quntity_left'  => ['nullable','numeric'],
            'stock_category_id' => ['required','integer'],
        ];
    }
}
