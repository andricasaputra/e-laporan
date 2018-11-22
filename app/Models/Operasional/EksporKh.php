<?php

namespace App\Models\Operasional;

use App\Models\Wilker;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\TanggalController as Tanggal;

class EksporKh extends Model implements ModelOperasionalInterface
{
    protected $table 	= 'ekspor_kh', 
    		  $guarded 	= ['id'],
 			  $hidden 	= ['id', 'user_id', 'wilker_id', 'role_id', 'no', 'created_at', 'updated_at'];

 	public function getBulanAttribute($value)
    {
        return Tanggal::bulanTahun($value);
    }

    public function wilker()
    {
    	return $this->belongsTo(Wilker::class);
    }
}
