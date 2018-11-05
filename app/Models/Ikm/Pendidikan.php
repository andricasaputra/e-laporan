<?php

namespace App\Models\Ikm;

use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    protected $table = 'ikm_pendidikan';
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $hidden = ['id', 'created_at', 'updated_at'];
}
