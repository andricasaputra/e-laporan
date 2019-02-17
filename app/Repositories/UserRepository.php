<?php 

namespace App\Repositories;

use App\Models\User;
use App\Traits\Repository;
use App\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UserRepository implements RepositoryInterface
{
	use Repository;

    /**
     * Untuk menyimpan instance dari model
     *
     * @var instance of App/Models/AnyModels
     */
	private $model;

    /**
     * Untuk set instance model yang harus dipakai 
     *
     * @return void 
     */
	public function __construct()
    {
        $this->model = new User;
    }

    /**
     * Untuk menampilkan API data users 
     *
     * @return Collections of Datatables 
     */
	public function api()
    {
    	$users = User::nonSuperAdmin();

        return datatables($users)->addIndexColumn()
                ->addColumn('action', function($users){
                    return '
                        <a href="'. route('users.edit', $users->pegawai->id) .'" class="btn btn-primary">
                            <i class="fa fa-edit"></i> Edit
                        </a> 
                        <a href="#" data-id = "'. $users->pegawai->id .'"  class="btn btn-danger" id="deleteUser">
                            <i class="fa fa-trash"></i> Delete
                        </a>';
                })->make(true);
    }

}