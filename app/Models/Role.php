<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $guarded = ['id', 'created_at', 'updated_at'];

	public function getRoleAttribute($value)
	{
		return ucfirst($value);
	}
	
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
