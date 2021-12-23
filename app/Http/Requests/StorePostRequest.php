<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            "title" => ['required','string','min:1','max:225'],
            'body' => ['required','string','min:50'],
            'sub_category_id' => ['required','integer','exists:sub_categories,id'],
        ];
    }

    public function messages()
    {
        return [
            '*.required' => "The :attribute field must be provided or can't be null"
            ];
    }
}
