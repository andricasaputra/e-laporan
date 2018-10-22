<?php

namespace App\Models\Operasional;

use Illuminate\Database\Eloquent\Model;

class ImporKt extends Model
{
    protected $table = 'impor_kt', 
    		  $primaryKey = 'no_permohonan', 
    		  $guarded = ['id'],
    		  $hidden = ['id', 'user_id', 'wilker_id', 'role_id', 'created_at', 'updated_at']; 
}
