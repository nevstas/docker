<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RowFile implements Rule
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
        $mime_type = $value->getClientMimeType();
        if (!in_array($mime_type, ['application/vnd.ms-office',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-excel'])) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The excel file must be a file of type: xls, xlsx.';
    }
}
