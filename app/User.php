<?php

namespace App;

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

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function wilker()
    {
        return $this->belongsTo('App\Wilker');
    }

    public function getUploadDokelKt()
    {
        return $this->belongsToMany('App\Models\Operasional\DokelKt');
    }
}
