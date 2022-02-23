<?php

namespace App\Http\Requests;

use App\Rules\RowFile;
use Illuminate\Foundation\Http\FormRequest;

class RowRequest extends FormRequest
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
            'import_file' => ['required', new RowFile()],
//            'import_file' => 'required|mimeTypes:'.
//                'application/vnd.ms-office,'.
//                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,'.
//                'application/vnd.ms-excel',
        ];
    }

}
