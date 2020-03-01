<?php

namespace App\Models;

use Illuminate\Http\Request;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasRoles;

    protected $connection   = 'usersDB';

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
        'pegawai', 'roles'
    ];

    public function pegawai()
    {
        return $this->hasOne(MasterPegawai::class);
    }

    public function wilker()
    {
        return $this->belongsToMany(Wilker::class);
    }

    public function roles()
    {
        return (new \App\User)->morphToMany(
            config('permission.models.role'),
            'model',
            config('permission.table_names.model_has_roles'),
            config('permission.column_names.model_morph_key'),
            'role_id'
        );
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
        return  $query->whereIn('id', [1,2,3,4,5])->get();
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
