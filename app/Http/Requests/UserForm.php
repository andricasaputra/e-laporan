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
        if (is_null($this->route('masterPegawai'))) {

            $this->uniqueRules = 'required|string|max:255|unique:users,username';
            
        } else {

            $this->uniqueRules = 'required|string|max:255|unique:users,username,' .$this->route('masterPegawai')->id. ',id';

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

     /**
     * Insert user baru kedalam database
     *
     * @return void
     */
    public function persistCreate()
    {
        $masterPegawai = Master::create(

            $this->only(['nama', 'nip', 'jenis_karantina', 'golongan_id', 'jabatan_id'])

        );

        return $masterPegawai;
    }

    /**
     * Update user
     *
     * @return void
     */
    public function persistUpdate(Master $masterPegawai)
    {
        $masterPegawai->update(

            $this->only(['nama', 'nip', 'jenis_karantina', 'golongan_id', 'jabatan_id'])

        ); 
    }

}
