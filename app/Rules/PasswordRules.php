<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PasswordRules implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // return preg_match("^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).+$" , $value);
        // return  preg_match("/(?=.*[a-z])(?=.*[A-Z])(?=.*[\d,.;:]).\+/",$value);
        return preg_match('^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$',$value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The password must contain a number, a lower case charater, an upper case letter and a special charater.';
    }
}
