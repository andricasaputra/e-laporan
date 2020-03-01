<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Golongan extends Model
{
	protected $connection   = 'usersDB';
    protected $guarded 	= ['id'];
}
