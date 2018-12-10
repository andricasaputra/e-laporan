<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\User;
use App\Models\Role;
use App\Models\Wilker;
use App\Models\Jabatan;
use App\Models\Golongan;
use Illuminate\Http\Request;
use App\Events\DeletePegawai;
use App\Events\UpdatePegawai;
use Illuminate\Support\Facades\Hash;
use App\Models\MasterPegawai as Master;

class UserController extends Controller
{
    public function index()
    {
        return view('auth.showusers');
    }

    public function edit(int $id)
    {
        $user       = User::with(['pegawai', 'role', 'wilker', 'golongan', 'jabatan'])->find($id);
        $roles      = Role::where('id', '!=', 1)->get();
        $wilkers    = Wilker::all();
        $jabatan    = Jabatan::all();
        $golongan   = Golongan::all();

        return view('auth.edit')
        ->with('user', $user)
        ->with('golongan_user', $user->golongan->first())
        ->with('jabatan_user', $user->jabatan->first())
        ->with('roles', $roles)
        ->with('wilkers', $wilkers)
        ->with('jabatan', $jabatan)
        ->with('golongan', $golongan);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([

            'wilker'            => 'required',
            'jenis_karantina'   => 'required|string',
            'role'              => 'required',
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
            'jabatan_id' => $request->jabatan
        ]);

        event(new UpdatePegawai($master, $request));

        return redirect(route('users.index'))->with('success', 'Data User Berhasil Diubah');
    }

    public function destroy(Request $request)
    {
        $user = User::where('pegawai_id', $request->id)->first();

        event(new DeletePegawai($user, $user->pegawai));

        /*Delete pegawai from master pegawai*/
        $user->pegawai()->delete();

        return redirect(route('users.index'))->with('success', 'Data User Berhasil Dihapus');
    }

    public function api()
    {
        $users = User::with('pegawai')->where('id', '!=', 1);
 
        return Datatables::of($users)->addIndexColumn()
            ->addColumn('action', function($users){

                return '
                <a href="'. route('users.edit', $users->pegawai->id) .'" class="btn btn-primary"><i class="fa fa-edit"></i> Edit
                </a> 
                <a href="#" data-id = "'.$users->pegawai->id.'"  class="btn btn-danger" id="deleteUser"><i class="fa fa-trash"></i> Delete</a>';

            })->rawColumns(['action'])->make(true);
    }
    
}
