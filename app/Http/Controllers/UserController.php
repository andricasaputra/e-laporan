<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Events\DeletePegawai;
<<<<<<< HEAD
use App\Events\UpdatePegawai;
use App\Events\RegisterPegawai;
use App\Http\Requests\UserForm;
use App\Repositories\UserRepository;
use App\Models\MasterPegawai as Master;
=======
use App\Http\Requests\UserForm;
use App\Models\MasterPegawai as Master;
use App\Repositories\UserRepository as Users;
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41

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
<<<<<<< HEAD
     * @param App\Repositories\UserRepository $repository
     * @return void
     */
    public function __construct(UserRepository $repository)
=======
     * @return App\Repositories Instance!
     */
    public function __construct(Users $repository)
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    {
        $this->repository = $repository;
    }

    /**
     * Show all user info page
     *
<<<<<<< HEAD
     * @return \Illuminate\Http\Response
=======
     * @return View
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function index()
    {
        return view('auth.showusers');
    }

    /**
     * Get a validator for an incoming registration request.
     *
<<<<<<< HEAD
     * @return \Illuminate\Http\Response
=======
     * @return View
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function showRegistrationForm()
    {        
        return view('auth.register');
    }

    /**
     * Create a new user instance after a valid registration.
     *
<<<<<<< HEAD
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserForm $request)
    {
        $pegawai = $request->persistCreate();

        event( new RegisterPegawai($pegawai, $request) );
=======
     * @param  Request  $request
     * @return \App\Models\User
     */
    public function store(UserForm $request)
    {
        $request->persistCreate();
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41

        return back()->withSuccess('User baru berhasil diregistrasi');
    }

    /**
     * Show edit form 
     *
<<<<<<< HEAD
     * @param  App\Models\User $user
     * @return \Illuminate\Http\Response
=======
     * @param  User Model Instance
     * @return \App\Models\User
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function edit(User $user)
    {
        return view('auth.edit')->withUser($user);         
    }

    /**
     * Update user account, wilker, role
     *
<<<<<<< HEAD
     * @param Illuminate\Http\Request $request 
     * @param App\Models\MasterPegawai $masterPegawai
     * @return \Illuminate\Http\Response
=======
     * @param  Request  $request & MasterPegawai Model Instance
     * @return \App\Models\User
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function update(UserForm $request, Master $masterPegawai)
    {
        $request->persistUpdate($masterPegawai);

<<<<<<< HEAD
        event( new UpdatePegawai($masterPegawai, $request) );

=======
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
        return redirect(route('users.index'))->withSuccess('Data User Berhasil Diubah');
    }

    /**
<<<<<<< HEAD
     * Delete user
     *
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
=======
     * Delete User.
     *
     * @param  Request $request
     * @return \App\Models\User
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
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
<<<<<<< HEAD
     * @return array
=======
     * @return Array JSON
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function api()
    {
        return $this->repository->api();
    }
    
}
