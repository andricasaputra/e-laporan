<?php

namespace App\Models\Ikm;

use Illuminate\Database\Eloquent\Model;

class Responden extends Model
{
    protected $table = 'ikm_responden';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getJenisKelaminAttribute($value)
    {
    	if($value == 1){

    		$value = 'Laki-laki';

    	}else{

    		$value = 'Perempuan';
    	}

    	return $value;
    }

    public function result()
    {
        return $this->belongsTo(Result::class, 'responden_id', 'ikm_id');
    }

    public function layanan()
    {
    	return $this->belongsTo(Layanan::class);
    }

    public function umur()
    {
    	return $this->belongsTo(Umur::class);
    }

    public function pendidikan()
    {
    	return $this->belongsTo(Pendidikan::class);
    }

    public function pekerjaan()
    {
    	return $this->belongsTo(Pekerjaan::class);
    }

}
