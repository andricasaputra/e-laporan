<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\DaftarWilker as Wilker;

class RegisterController extends Controller
{

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    /*protected $redirectTo = '/home';*/

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
        $wilker = Wilker::all();
        return view('auth.register')->with('wilker', $wilker);
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
            'wilker' => 'required|string|max:255',
            'bagian' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'wilker_id' => $data['wilker'],
            'username' => $data['username'],
            'bagian' => $data['bagian'],
            'role_id' => $data['role'],
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
        ]);
    }
    
}
