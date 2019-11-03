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
<<<<<<< HEAD
        return (int) $value === 1 ? 'Pegawai Aktif' : 'Pensiun/Mutasi';
=======
        return  $value === 1 || $value === "1"
                ? 'Pegawai Aktif' : 'Pensiun/Mutasi';
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    }

    public function user()
    {
<<<<<<< HEAD
        return $this->hasOne(User::class, 'pegawai_id');
=======
        return $this->belongsTo(User::class, 'pegawai_id');
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
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
<<<<<<< HEAD
        return $this->hasOne(Profile::class, 'master_pegawai_id');
=======
        return $this->belongsTo(Profile::class, 'master_pegawai_id');
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
    }
}
