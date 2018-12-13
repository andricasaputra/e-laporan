<?php

namespace App\Models\Operasional;

use App\Models\Wilker;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\ModelOperasionalInterface;
use App\Http\Controllers\TanggalController as Tanggal;

class DomasKh extends Model implements ModelOperasionalInterface
{
    protected $table 	= 'domas_kh', 
    		  $guarded 	= ['id', 'created_at', 'updated_at'],
 			  $hidden 	= ['id', 'user_id', 'wilker_id', 'role_id', 'no', 'created_at', 'updated_at'];

 	/*public function user()
 	{
 		return $this->belongsTo('App\User');
 	}*/

 	public function getBulanAttribute($value)
    {
        return Tanggal::bulanTahun($value);
    }

    public function wilker()
    {
    	return $this->belongsTo(Wilker::class);
    }
}
