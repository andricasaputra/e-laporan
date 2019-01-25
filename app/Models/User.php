<?php

namespace App\Models;

use Illuminate\Http\Request;
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

    /**
     * The attributes for eager loading relations.
     *
     * @var array
     */
    protected $with = [
        'pegawai', 'golongan', 'jabatan'
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
        return $this->belongsToMany(Wilker::class, 'wilker_users');
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
        return $this->belongsToMany(\Operasional\DokelKt::class);
    }

    public function scopePegawaiDetail($query, $pegawaiId)
    {
        return $query->wherePegawaiId($pegawaiId['id']);
    }

    public function scopeUserToNotify($query)
    {
        return  $query->with(['role' => function ($query) { 

                    $query->whereIn('role_id', [1, 2, 3]);
                     
                }]);
    }

    public function scopeSendNotify($query, $wilker_id)
    {
        return  $query->with(['wilker' => function($query) use ($wilker_id) {

                    $query->where('wilker.id', '!=', $wilker_id);

                }]);
    }

    public function scopeNonSuperAdmin($query)
    {
        return $query->where('id', '!=', 1);
    }

}
