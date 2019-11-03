<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
<<<<<<< HEAD
use App\Repositories\Operasional\Upload\UploadValidator;
=======
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41

class UploadOperasionalRequest extends FormRequest
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

            'wilker_id' => 'required',
            'filenya' => 'required|mimes:xls,xlsx'
            
        ];
    }
}
