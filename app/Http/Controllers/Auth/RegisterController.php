<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Role;
use App\Models\Wilker;
use App\Models\Jabatan;
use App\Models\Golongan;
use Illuminate\Http\Request;
use App\Events\RegisterPegawai;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\MasterPegawai as Master;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function showRegistrationForm()
    {
        $roles      = Role::where('id', '!=', 1)->get();
        $wilker     = Wilker::all();
        $jabatan    = Jabatan::all();
        $golongan   = Golongan::all();
        
        return view('auth.register')
        ->with('roles', $roles)
        ->with('wilker', $wilker)
        ->with('jabatan', $jabatan)
        ->with('golongan', $golongan);
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'wilker' => 'required|string',
            'nip' => 'max:18',
            'role' => 'required',
            'nama' => 'required|string',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $pegawai = Master::create([
            'nama' => $data['nama'],
            'nip' => $data['nip'],
            'jenis_karantina' => $data['jenis_karantina'],
            'golongan_id' => $data['golongan'],
            'jabatan_id' => $data['jabatan'],
            'wilker_id' => $data['wilker'],
            'wilker_id_2' => $data['wilker_2']
        ]);

        event(new RegisterPegawai($pegawai, $data));       
    }

}
