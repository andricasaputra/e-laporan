<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\DeletePegawai;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Models\MasterPegawai as Master;

class UserController extends Controller
{
    protected $repository;

    public function __construct(UserRepository $user)
    {
        $this->repository = $user;
    }

    /**
     * Show all user info page
     *
     * @return View
     */
    public function index()
    {
        return view('auth.showusers');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return View
     */
    public function showRegistrationForm()
    {        
        return view('auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  Request  $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request)
    {
        return $this->validate($request, [

            'wilker' => 'required',
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
     * @param  Request  $request
     * @return \App\Models\User
     */
    public function create(Request $request)
    {
        $this->validator($request);

        Master::create([

            'nama' => $request->nama,
            'nip' => $request->nip,
            'jenis_karantina' => $request->jenis_karantina,
            'golongan_id' => $request->golongan,
            'jabatan_id' => $request->jabatan

        ]);

        return back()->with('success', 'User baru berhasil diregistrasi');
    }

    /**
     * Show edit form 
     *
     * @param  User Model Instance
     * @return \App\Models\User
     */
    public function edit(User $user)
    {
        $user       = $this->repository->edit($user)->first();

        $relations  = $this->repository->setRelationsWithParams($user);

        return view('auth.edit')->with(compact('user', 'relations'));         
    }

    /**
     * Update user account, wilker, role
     *
     * @param  Request  $request & MasterPegawai Model Instance
     * @return \App\Models\User
     */
    public function update(Request $request, Master $masterPegawai)
    {
        $request->validate([

            'wilker'            => 'required',
            'jenis_karantina'   => 'required|string',
            'role'              => 'required',
            'nama'              => 'required|string',
            'username'          => 'required|string',
            'password'          => 'required|string|min:6|confirmed',

        ]); 

        $masterPegawai->update([

            'nama' => $request->nama,
            'nip' => $request->nip,
            'jenis_karantina' => $request->jenis_karantina,
            'golongan_id' => $request->golongan,
            'jabatan_id' => $request->jabatan

        ]); 

        return redirect()->route('users.index')
                ->with('success', 'Data User Berhasil Diubah');
    }

    /**
     * Delete User.
     *
     * @param  Request $request
     * @return \App\Models\User
     */
    public function destroy(Request $request)
    {
        $user = User::where('pegawai_id', $request->id)->first();

        event(new DeletePegawai($user, $user->pegawai));

        /*Delete pegawai from master pegawai*/
        $user->pegawai()->delete();

        return redirect()->route('users.index')
                ->with('success', 'Data User Berhasil Dihapus');
    }

    /**
     * Show user data trough API
     *
     * @return Array JSON of Datatables
     */
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
