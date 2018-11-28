<?php

namespace App\Models\Ikm;

use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
	protected $connection   = 'mysql2';
    protected $table 		= 'ikm_pekerjaan';
    protected $guarded 		= ['id', 'created_at', 'updated_at'];
    protected $hidden 		= ['id', 'created_at', 'updated_at'];
}
