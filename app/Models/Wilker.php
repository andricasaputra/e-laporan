<?php

namespace App\Models;

use App\Models\Operasional\LogInfo;
use Illuminate\Database\Eloquent\Model;

class Wilker extends Model
{
    protected $table    = 'wilker';
    protected $guarded  = ['id', 'created_at', 'updated_at'];

    public function logInfo()
    {
    	return $this->hasMany(LogInfo::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'wilker_users');
    }
}
