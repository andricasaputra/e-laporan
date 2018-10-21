<?php

namespace App\Models\Operasional;

use Illuminate\Database\Eloquent\Model;

class DokelKt extends Model
{
    protected $table = 'dokel_kt', 
    		  $primaryKey = 'no_permohonan', 
    		  $guarded = ['id']; 
}
