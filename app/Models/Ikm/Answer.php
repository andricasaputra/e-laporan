<?php

namespace App\Models\Ikm;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'ikm_answer';
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $hidden = ['id', 'created_at', 'updated_at'];

}
