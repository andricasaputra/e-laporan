<?php

namespace App\Models;

use App\Models\Operasional\LogInfo;
use Illuminate\Database\Eloquent\Model;

class Wilker extends Model
{
    protected $connection   = 'usersDB';
    protected $guarded  = ['id', 'created_at', 'updated_at'];
    protected $hidden   = ['id', 'created_at', 'updated_at'];
    protected $appends  = ['original_nama_wilker'];

    public function getNamaWilkerAttribute($value)
    {
        $except = config('e-operasional.wilker_except.original');

        // Khusus bandara salahuddin yang punya naming berbeda pada IQFAST
        if ($value == $except) {

            $value = config('e-operasional.wilker_except.replacement');

        } else {

            $x = explode(" ", $value);

            $wilker = preg_replace('/^[A-Za-z.]+[.]/', '', end($x));

            foreach (config('e-operasional.wilker') as $w) {
                if (strripos($w, $wilker)) {
                    $value = $w;
                }
            }
        }
        
        return $value;
    }

    public function getOriginalNamaWilkerAttribute()
    {
        return $this->getOriginal('nama_wilker');
    }

    public function logInfo()
    {
    	return $this->hasMany(LogInfo::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
