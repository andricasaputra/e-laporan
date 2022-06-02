<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ButirPktPenyelia extends Model
{
    use HasFactory;

    protected $table = 'bk_pkt_penyelia';
    protected $guarded = ['id'];
}
