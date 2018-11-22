<?php

namespace App\Models\Ikm;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table 	= 'ikm_question';
    protected $guarded 	= ['id', 'created_at', 'updated_at'];
    protected $hidden 	= ['id', 'answer_id', 'created_at', 'updated_at'];

    public function answer()
    {
    	return $this->belongsToMany(Answer::class, 'ikm_answer_question');
    }

    public function question_answer()
    {
    	return $this->belongsToMany(Answer::class, 'ikm_answer_question');
    }
}
