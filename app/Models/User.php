<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at'
    ];

    public function pegawai()
    {
        return $this->belongsTo(MasterPegawai::class);
    }

    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_users');
    }

    public function wilker()
    {
        return $this->hasManyThrough(Wilker::class, MasterPegawai::class, 'id', 'id', 'id', 'wilker_id');
    }

    public function golongan()
    {
        return $this->hasManyThrough(Golongan::class, MasterPegawai::class, 'id', 'id', 'id', 'golongan_id');
    }

    public function jabatan()
    {
        return $this->hasManyThrough(Jabatan::class, MasterPegawai::class, 'id', 'id', 'id', 'jabatan_id');
    }

    public function getUploadDokelKt()
    {
        return $this->belongsToMany('App\Models\Operasional\DokelKt');
    }
    
}
