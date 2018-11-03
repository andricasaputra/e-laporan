<?php

namespace App\Models\Ikm;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'ikm_answer';
    protected $fillable = ['question_id', 'answer'];

    public function question()
    {
    	return $this->belongsToMany(Question::class);
    }
}
