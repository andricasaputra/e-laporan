<?php

namespace App\Models\Operasional;

use Illuminate\Database\Eloquent\Model;

class EksporKt extends Model
{
    protected $table = 'ekspor_kt', 
    		  $primaryKey = 'no_permohonan', 
    		  $guarded = ['id']; 
}
