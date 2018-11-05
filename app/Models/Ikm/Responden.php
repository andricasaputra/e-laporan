<?php

namespace App\Models\Ikm;

use Illuminate\Database\Eloquent\Model;

class Responden extends Model
{
    protected $table = 'ikm_responden';
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $hidden = ['layanan_id', 'pendidikan_id', 'umur_id', 'pekerjaan_id', 'updated_at'];

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

    public function ikm()
    {   
        /*This hasManyThrough relation query = this query
        select `ikm`.*, `ikm_result`.`responden_id` from `ikm` inner join `ikm_result` on `ikm_result`.`ikm_id` = `ikm`.`id` where `ikm_result`.`responden_id` = 18*/

        return $this->hasManyThrough(Jadwal::class, Result::class, 'responden_id', 'id', 'id', 'ikm_id')
        ->groupBy('ikm_result.responden_id');
    }

    public function question()
    {   
        /*This hasManyThrough relation query = this query
        select `ikm_question`.*, `ikm_result`.`responden_id` from `ikm_question` inner join `ikm_result` on `ikm_result`.`question_id` = `ikm_question`.`id` where `ikm_result`.`responden_id` = 18*/

        return $this->hasManyThrough(Question::class, Result::class, 'responden_id', 'id', 'id', 'question_id');
    }

    public function answer()
    {   
        /*This hasManyThrough relation query = this query
        select `ikm_answer`.*, `ikm_result`.`responden_id` from `ikm_answer` inner join `ikm_result` on `ikm_result`.`answer_id` = `ikm_answer`.`id` where `ikm_result`.`responden_id` = 18*/

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

}
