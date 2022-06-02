<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ButirPktTerampil extends Model
{
    use HasFactory;

    protected $table = 'bk_pkt_terampil';
    protected $guarded = ['id'];
}
