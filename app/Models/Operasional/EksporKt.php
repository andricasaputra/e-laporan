<?php

namespace App\Models\Operasional;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\TanggalController as Tanggal;

class EksporKt extends Model
{
    protected $table = 'ekspor_kt', 
    		  $guarded = ['id'],
    		  $hidden = ['id', 'user_id', 'wilker_id', 'role_id', 'no', 'created_at', 'updated_at'];

    public function getBulanAttribute($value)
    {
        return Tanggal::bulanTahun($value);
    }
}
