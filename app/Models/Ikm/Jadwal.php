<?php

namespace App\Models\Ikm;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\TanggalController as Tanggal;

class Jadwal extends Model
{
    protected $connection   = 'mysql2';
	protected $table        = 'ikm';
    protected $guarded      = ['id', 'created_at', 'updated_at'];
    protected $hidden       = ['id','start_date', 'end_date', 'is_open', 'created_at', 'updated_at'];
    // protected $with         = ['responden'];

    public function result()
    {
        return $this->hasMany(Result::class, 'ikm_id');
    }

    /*Ini Cara yang Baru - kolom ikm_id sudah ditambahkan ke table responden untuk mempermudah pembacaan relasi*/
    public function responden()
    {   
        return $this->hasMany(Responden::class, 'ikm_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_open', 1)->where('is_open', '!=', NULL);
    }
}
