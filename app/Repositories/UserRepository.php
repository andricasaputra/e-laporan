<?php 

namespace App\Repositories;

use DataTables;
use App\Models\User;
use App\Traits\Repository;
use App\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UserRepository implements RepositoryInterface
{
	use Repository;

	private $model;

	public function __construct()
    {
        $this->model = new User;
    }

	public function api()
    {
    	$users = User::where('id', '!=', 1);

        return Datatables::of($users)->addIndexColumn()
                ->addColumn('action', function($users){
                    return '
                        <a href="'. route('users.edit', $users->pegawai->id) .'" class="btn btn-primary">
                            <i class="fa fa-edit"></i> Edit
                        </a> 
                        <a href="#" data-id = "'.$users->pegawai->id.'"  class="btn btn-danger" id="deleteUser">
                            <i class="fa fa-trash"></i> Delete
                        </a>';
                })
                ->rawColumns(['action'])
                ->make(true);
    }

}