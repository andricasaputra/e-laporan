<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $guarded = ['id', 'created_at', 'updated_at'];

	public function getNameAttribute($value)
	{
		return ucfirst($value);
	}
	
    public function user()
    {
    	return $this->belongsToMany(User::class, 'role_users');
    }
}
