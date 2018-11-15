<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wilker extends Model
{
    protected $table = 'wilker';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user()
    {
    	return $this->hasMany(User::class);
    }
}
