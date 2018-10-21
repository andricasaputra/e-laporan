<?php

namespace App\Models\Operasional;

use Illuminate\Database\Eloquent\Model;

class ImporKt extends Model
{
    protected $table = 'impor_kt', 
    		  $primaryKey = 'no_permohonan', 
    		  $guarded = ['id']; 
}
