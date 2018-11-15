<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profile';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function pegawai()
    {
    	return $this->belongsTo(MasterPegawai::class);
    }
}
