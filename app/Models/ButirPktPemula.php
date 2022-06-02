<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ButirPktPemula extends Model
{
    use HasFactory;

    protected $table = 'bk_pkt_pemula';
    protected $guarded = ['id'];
}
