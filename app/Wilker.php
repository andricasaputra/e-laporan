<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wilker extends Model
{
    protected $table = 'wilker';

    public function user()
    {
    	return $this->hasMany('App\User');
    }
}
