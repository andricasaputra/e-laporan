<?php

namespace App\Models\Operasional;

use Illuminate\Database\Eloquent\Model;

class ReeksporKh extends Model
{
    protected $table 	= 'reekspor_kh';
    protected $guarded  = ['id', 'created_at', 'updated_at'];
    protected $hidden   = ['id', 'user_id', 'wilker_id', 'no', 'created_at', 'updated_at'];
}
