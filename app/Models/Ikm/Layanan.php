<?php

namespace App\Models\Ikm;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'ikm_layanan';
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $hidden = ['id', 'created_at', 'updated_at'];
}
