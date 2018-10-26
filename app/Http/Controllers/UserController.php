<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\User;
use App\Wilker;
use DataTables;

class UserController extends Controller
{

    public function index()
    {
        return view('auth.showusers');
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
            'username'  => $data['username'],
            'bagian'    => $data['bagian'],
            'role_id'   => $data['role'],
            'name'      => $data['name'],
            'password'  => Hash::make($data['password']),
        ]);
    }

    public function edit($id)
    {
        $wilkers    = Wilker::all();
        $user       = User::find($id);
        $wilker     = $user->wilker;
        $role       = $user->role;
        return view('auth.edit')->with('user', $user)
        ->with('wilker', $wilker)
        ->with('role', $role)
        ->with('wilkers', $wilkers);
    }

    public function update(Request $request, $id)
    {
        $request->validate([

            'wilker'    => 'required|string|max:255',
            'bagian'    => 'required|string|max:255',
            'role'      => 'required|string|max:255',
            'name'      => 'required|string|max:255',
            'username'  => 'required|string|max:255',
            'password'  => 'required|string|min:6|confirmed',

        ]); 

        $user = User::find($id);

        $user->wilker_id    = $request->wilker;
        $username           = $request->username;
        $user->bagian       = $request->bagian;
        $user->role_id      = $request->role;
        $user->name         = $request->name;
        $user->password     = Hash::make($request->password);

        if($user->save()){

            return redirect(route('users.show'))->with('success', 'Data User Berhasil Diubah');

        }

        return redirect()->back()->with('warning', 'Terjadi Kesalahan, Gagal Ubah Data');

    }

    public function api()
    {
        $users = User::all();
 
        return Datatables::of($users)
            ->addColumn('action', function($users){

                return '<a href="'. route('users.edit', $users->id) .'" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</a>';

            })->rawColumns(['action'])->make(true);
    }
    
}
