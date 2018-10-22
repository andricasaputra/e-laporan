<?php

namespace App\Models\Operasional;

use Illuminate\Database\Eloquent\Model;

class DokelKt extends Model
{
    protected $table = 'dokel_kt', 
    		  $primaryKey = 'no_permohonan', 
    		  $guarded = ['id'],
 			  $hidden = ['id', 'user_id', 'wilker_id', 'role_id', 'created_at', 'updated_at'];

 	public function user()
 	{
 		return $this->belongsTo('App\User');
 	}
}
