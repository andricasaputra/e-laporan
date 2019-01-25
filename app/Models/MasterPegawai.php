<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterPegawai extends Model
{
    protected $table    = 'master_pegawai';
    protected $guarded  = ['id', 'created_at', 'updated_at'];
    protected $hidden   = ['id', 'created_at', 'updated_at'];

    public function getIsActiveAttribute($value)
    {
        return  $value === 1 || $value === "1"
                ? 'Pegawai Aktif' : 'Pensiun/Mutasi';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'pegawai_id');
    }

    public function golongan()
    {
        return $this->hasOne(Golongan::class, 'id', 'golongan_id');
    }

    public function jabatan()
    {
        return $this->hasOne(Jabatan::class, 'id', 'jabatan_id');
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'master_pegawai_id');
    }
}
