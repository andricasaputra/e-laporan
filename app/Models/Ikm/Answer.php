<?php

namespace App\Models\Ikm;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table    = 'ikm_answer';
    protected $guarded  = ['id', 'created_at', 'updated_at'];
    protected $hidden   = ['created_at', 'updated_at']; 

    public function result()
    {
    	return $this->belongsToMany(Result::class, 'ikm_answer', 'nilai', 'id');
    }

    public function question_answer()
    {
    	return $this->belongsToMany(Answer::class, 'ikm_answer_question');
    }

}
