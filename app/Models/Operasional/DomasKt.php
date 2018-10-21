<?php

namespace App\Models\Operasional;

use Illuminate\Database\Eloquent\Model;

class DomasKt extends Model
{
    protected $table = 'domas_kt', 
    		  $primaryKey = 'no_permohonan', 
    		  $guarded = ['id']; 
}
