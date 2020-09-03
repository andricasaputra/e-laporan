<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class MasterPegawai extends Model
{
    protected $connection  = 'usersDB';
    protected $guarded = ['id'];
    protected $hidden = ['id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jabatan()
    {
    	return $this->hasMany(ModelHasRole::class, 'model_id', 'user_id');
    }
}
