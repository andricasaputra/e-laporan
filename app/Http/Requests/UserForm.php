<?php

namespace App\Http\Requests;

use App\Models\MasterPegawai as Master;
use Illuminate\Foundation\Http\FormRequest;

class UserForm extends FormRequest
{
    private $uniqueRules;

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
<<<<<<< HEAD
        if (is_null($this->route('masterPegawai'))) {
=======
        if (is_null($this->masterPegawai)) {
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41

            $this->uniqueRules = 'required|string|max:255|unique:users,username';
            
        } else {

<<<<<<< HEAD
            $this->uniqueRules = 'required|string|max:255|unique:users,username,' .$this->route('masterPegawai')->id. ',id';
=======
            $this->uniqueRules = 'required|string|max:255|unique:users,username,' .$this->masterPegawai->id. ',id';
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41

        }

        return [

            'wilker' => 'required',
            'nip' => 'max:18',
            'role' => 'required',
            'nama' => 'required|string',
            'username' => $this->uniqueRules,
            'password' => 'required|string|min:6|confirmed',

        ]; 
    }

<<<<<<< HEAD
     /**
     * Insert user baru kedalam database
     *
     * @return void
     */
    public function persistCreate()
    {
        $masterPegawai = Master::create(
=======
    public function persistCreate()
    {
        Master::create(
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41

            $this->only(['nama', 'nip', 'jenis_karantina', 'golongan_id', 'jabatan_id'])

        );
<<<<<<< HEAD

        return $masterPegawai;
    }

    /**
     * Update user
     *
     * @return void
     */
=======
    }

>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    public function persistUpdate(Master $masterPegawai)
    {
        $masterPegawai->update(

            $this->only(['nama', 'nip', 'jenis_karantina', 'golongan_id', 'jabatan_id'])

        ); 
    }

}
