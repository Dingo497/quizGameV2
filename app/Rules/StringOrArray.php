<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StringOrArray implements Rule
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
        if(is_array($value)) {
            foreach($value as $key => $val) {
                if(is_string($val)) return $value; 
            }
        } else {
            if(is_string($value)) return $value;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be string or array of strings.';
    }
}
