<?php

namespace App\Models;

use App\Models\Operasional\LogInfo;
use Illuminate\Database\Eloquent\Model;

class Wilker extends Model
{
    protected $table    = 'wilker';
    protected $guarded  = ['id', 'created_at', 'updated_at'];
    protected $hidden   = ['id', 'created_at', 'updated_at'];
<<<<<<< HEAD
    protected $appends  = ['original_nama_wilker'];

    public function getNamaWilkerAttribute($value)
    {
        if ($value == 'Wilker Bandara Sultan M.Salahuddin') {

            $value = 'Wilker Bandara M. Salahudin';

        } elseif($value == 'Wilker Bandara Sultan M.Kaharuddin') {
            
            $value = 'Wilker Bandara Brang Biji';
        }

        return $value;
    }

    public function getOriginalNamaWilkerAttribute()
    {
        return $this->getOriginal('nama_wilker');
    }
=======
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41

    public function logInfo()
    {
    	return $this->hasMany(LogInfo::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'wilker_users');
    }
}
