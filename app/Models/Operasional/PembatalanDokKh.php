<?php

namespace App\Models\Operasional;

use Illuminate\Database\Eloquent\Model;

class PembatalanDokKh extends Model
{
    protected $table 	= 'pembatalan_dok_kt';
    protected $guarded  = ['id', 'created_at', 'updated_at'];
    protected $hidden   = ['id', 'user_id', 'wilker_id', 'no', 'created_at', 'updated_at'];
}
