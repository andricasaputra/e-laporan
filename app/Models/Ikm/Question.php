<?php

namespace App\Models\Ikm;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'ikm_question';
    protected $fillable = ['question'];

    public function answer()
    {
    	return $this->belongsToMany(Answer::class);
    }
}
