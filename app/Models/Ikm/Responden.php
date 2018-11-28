<?php

namespace App\Models\Ikm;

use Illuminate\Database\Eloquent\Model;

class Responden extends Model
{
    protected $connection   = 'mysql2';
    protected $table        = 'ikm_responden';
    protected $guarded      = ['id', 'created_at', 'updated_at'];
    protected $hidden       = ['layanan_id', 'pendidikan_id', 'umur_id', 'pekerjaan_id', 'updated_at'];

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
        return $this->hasMany(Result::class);
    }

    /*Ini Cara Lama ketika kolom ikm_id belum ditambahkan ke table responden*/
    public function ikm()
    {   
        /*This hasManyThrough relation query = this query
        select `ikm`.*, `ikm_result`.`responden_id` from `ikm` inner join `ikm_result` on `ikm_result`.`ikm_id` = `ikm`.`id` where `ikm_result`.`responden_id` = whatever_responden_id*/

        return $this->hasManyThrough(Jadwal::class, Result::class, 'responden_id', 'id', 'id', 'ikm_id')
        ->groupBy('ikm_result.responden_id');
    }

    /*Ini Cara yang Baru - kolom ikm_id sudah ditambahkan ke table responden untuk mempermudah pembacaan relasi*/
    public function jadwal()
    {   
        return $this->belongsTo(Jadwal::class, 'ikm_id');
    }

    public function question()
    {   
        return $this->hasManyThrough(Question::class, Result::class, 'responden_id', 'id', 'id', 'question_id');
    }

    public function answer()
    {   
        return $this->hasManyThrough(Answer::class, Result::class, 'responden_id', 'id', 'id', 'answer_id');
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

    public function sumRating()
    {
        return $this->answer()
          ->selectRaw('sum(nilai) as aggregate')
          ->groupBy('responden_id');
    }

    public function getSumRatingAttribute()
    {
        if ( ! array_key_exists('sumRating', $this->relations)) {
           $this->load('sumRating');
        }

        $relation = $this->getRelation('sumRating')->first();

        return ($relation) ? $relation->aggregate : null;
    }

}
