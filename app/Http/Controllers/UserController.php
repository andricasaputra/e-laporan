<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Wilker;
use App\Models\Jabatan;
use App\Models\Golongan;
use App\Models\MasterPegawai as Master;
use DataTables;

class UserController extends Controller
{

    public function index()
    {
        return view('auth.showusers');
    }


    public function edit($id)
    {
        $user       = User::with(['pegawai', 'role'])->find($id);
        $roles      = Role::where('id', '!=', 1)->get();
        $wilkers    = Wilker::all();
        $jabatan    = Jabatan::all();
        $golongan   = Golongan::all();

        return view('auth.edit')
        ->with('user', $user)
        ->with('wilker_user', $user->wilker->first())
        ->with('golongan_user', $user->golongan->first())
        ->with('jabatan_user', $user->jabatan->first())
        ->with('roles', $roles)
        ->with('wilkers', $wilkers)
        ->with('jabatan', $jabatan)
        ->with('golongan', $golongan);
    }

    public function update(Request $request, $id)
    {
        $request->validate([

            'wilker'            => 'required|string',
            'jenis_karantina'   => 'required|string',
            'role'              => 'required|string',
            'nama'              => 'required|string',
            'username'          => 'required|string',
            'password'          => 'required|string|min:6|confirmed',

        ]); 

        $master = Master::find($id);

        $master->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'jenis_karantina' => $request->jenis_karantina,
            'golongan_id' => $request->golongan,
            'jabatan_id' => $request->jabatan,
            'wilker_id' => $request->wilker
        ]);

        $master->user()->update([
            'role_id' => $request->role,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);

        $master->profile()->update([
            'nama' => $request->nama
        ]);

        return redirect(route('users.index'))->with('success', 'Data User Berhasil Diubah');
    }

    public function api()
    {
        $users = User::with('pegawai');
 
        return Datatables::of($users)
            ->addColumn('action', function($users){

                return '<a href="'. route('users.edit', $users->pegawai->id) .'" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>';

            })->rawColumns(['action'])->make(true);
    }
    
}
