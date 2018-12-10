<?php 

namespace App\Repositories;

use App\Models\User;
use App\Traits\MainRepositoryTrait;
use Illuminate\Database\Eloquent\Model;

class UserRepository implements RepositoryInterface
{
	use MainRepositoryTrait;

	public $model;

	public function __construct()
	{
		$this->model = new User;
	}

	public function setRelationsWithParams(User $user)
	{
		return $this->model->with(['golongan', 'jabatan'])
				->where('id', $user->id)
				->first();
	}
}