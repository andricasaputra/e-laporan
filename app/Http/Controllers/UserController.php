<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Events\DeletePegawai;
use App\Http\Requests\UserForm;
use App\Models\MasterPegawai as Master;
use App\Repositories\UserRepository as Users;

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
     * @return App\Repositories Instance!
     */
    public function __construct(Users $repository)
    {
        $this->repository = $repository;
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
     * Create a new user instance after a valid registration.
     *
     * @param  Request  $request
     * @return \App\Models\User
     */
    public function store(UserForm $request)
    {
        $request->persistCreate();

        return back()->withSuccess('User baru berhasil diregistrasi');
    }

    /**
     * Show edit form 
     *
     * @param  User Model Instance
     * @return \App\Models\User
     */
    public function edit(User $user)
    {
        return view('auth.edit')->withUser($user);         
    }

    /**
     * Update user account, wilker, role
     *
     * @param  Request  $request & MasterPegawai Model Instance
     * @return \App\Models\User
     */
    public function update(UserForm $request, Master $masterPegawai)
    {
        $request->persistUpdate($masterPegawai);

        return redirect(route('users.index'))->withSuccess('Data User Berhasil Diubah');
    }

    /**
     * Delete User.
     *
     * @param  Request $request
     * @return \App\Models\User
     */
    public function destroy(Request $request)
    {
        $user = User::pegawaiDetail($request->only('id'))->first();

        event(new DeletePegawai($user, $user->pegawai));

        /*Delete pegawai from master pegawai*/
        $user->pegawai()->delete();

        return redirect(route('users.index'))->withSuccess('Data User Berhasil Dihapus');
    }

    /**
     * Show user data trough API
     *
     * @return Array JSON
     */
    public function api()
    {
        return $this->repository->api();
    }
    
}
