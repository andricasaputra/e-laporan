<?php

namespace App\Http\Requests;

use App\Models\Ikm\Responden;
use Illuminate\Foundation\Http\FormRequest;

class SurveyIkmForm extends FormRequest
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

            'layanan_id' => 'required',
            'jenis_kelamin' => 'required',
            'umur_id' => 'required',
            'pendidikan_id' => 'required',
            'pekerjaan_id' => 'required',

        ];

    }

<<<<<<< HEAD
    /**
     * Insert survey baru ke dalam database
     *
     * @return object
     */
=======
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    public function persistCreate()
    {
        $responden = Responden::create(

           $this->only(['ikm_id', 'layanan_id', 'jenis_kelamin', 'umur_id', 'pendidikan_id', 'pekerjaan_id'])

        );

        $answer = $this->except(

            ['ikm_id','layanan_id','jenis_kelamin','umur_id','pendidikan_id','pekerjaan_id','_token']

        );

        foreach ($answer as $key => $value) {

            $responden->result()->create([

                'ikm_id' => $this->ikm_id,
                'responden_id' => $responden->id,
                'question_id' => $key,
                'answer_id' => $value[0]

            ]);
            
        }

        return $responden->id;
    }

}
