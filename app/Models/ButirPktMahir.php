<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ButirPktMahir extends Model
{
    use HasFactory;

    protected $table = 'bk_pkt_mahir';
    protected $guarded = ['id'];
}
