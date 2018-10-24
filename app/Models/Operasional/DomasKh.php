<?php

namespace App\Models\Operasional;

use Illuminate\Database\Eloquent\Model;

class DomasKh extends Model
{
    protected $table = 'domas_kh', 
    		  $guarded = ['id'],
 			  $hidden = ['id', 'user_id', 'wilker_id', 'role_id', 'no', 'created_at', 'updated_at'];

 	/*public function user()
 	{
 		return $this->belongsTo('App\User');
 	}*/
}
