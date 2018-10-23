<?php

namespace App\Models\Operasional;

use Illuminate\Database\Eloquent\Model;

class DomasKt extends Model
{
    protected $table = 'domas_kt', 
    		  $guarded = ['id'],
    		  $hidden = ['id', 'user_id', 'wilker_id', 'role_id', 'no', 'created_at', 'updated_at'];

    /*public function user()
 	{
 		return $this->belongsTo('App\User');
 	}*/
}
