<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Events\DeletePegawai;
use App\Events\UpdatePegawai;
use App\Events\RegisterPegawai;
use App\Http\Requests\UserForm;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Models\MasterPegawai as Master;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Class Info
    |--------------------------------------------------------------------------
    |
    | * Use Repository -> App\UserRepository
    | * Use View Composer -> App\ViewServiceProvider
    | * Use Form Request to handle request -> App\Http\Request\UserForm
    | * Use Class Observer to delegate some Events -> App\Observers\UserObserver
    |
    */
    
    /**
     * For keep repository instance on the bag
     *
     * @var App\Repositories\UserRepository
     */
    private $repository;

    /**
     * Set what repositories should use for this class
     *
     * @param App\Repositories\UserRepository $repository
     * @return void
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Show all user info page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.showusers');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {        
        return view('auth.register');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserForm $request)
    {
        $pegawai = $request->persistCreate();

        event( new RegisterPegawai($pegawai, $request) );

        return back()->withSuccess('User baru berhasil diregistrasi');
    }

    /**
     * Show edit form 
     *
     * @param  App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if ($user->id == 2) {
           return view('auth.edit_admin')->withUser($user);
        }

        if (is_null($user->golongan)) {
            return back()->withWarning('Data pegawai tidak mempunyai golongan serta jabatan!');
        }

        return view('auth.edit')->withUser($user);         
    }

    /**
     * Update user account, wilker, role
     *
     * @param Illuminate\Http\Request $request 
     * @param App\Models\MasterPegawai $masterPegawai
     * @return \Illuminate\Http\Response
     */
    public function update(UserForm $request, Master $masterPegawai)
    {
        $request->persistUpdate($masterPegawai);

        event( new UpdatePegawai($masterPegawai, $request) );

        return redirect(route('users.index'))->withSuccess('Data User Berhasil Diubah');
    }

    /**
     * Update admin account
     *
     * @param Illuminate\Http\Request $request 
     * @param App\Models\MasterPegawai $masterPegawai
     * @return \Illuminate\Http\Response
     */
    public function updateAdmin(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user->update([
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);

        return redirect(route('users.index'))->withSuccess('Data Admin Berhasil Diubah');
    }

    /**
     * Delete user
     *
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::pegawaiDetail($request->only('id'))->first();

        event( new DeletePegawai($user, $user->pegawai) );

        /*Delete pegawai from master pegawai*/
        $user->pegawai()->delete();

        return redirect(route('users.index'))->withSuccess('Data User Berhasil Dihapus');
    }

    /**
     * Show user data trough API
     *
     * @return array
     */
    public function api()
    {
        return $this->repository->api();
    }
    
}
