<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ButirPktTerampil extends Model
{
    use HasFactory;

    protected $table = 'bk_pkt_terampil';
    protected $guarded = ['id'];

    protected function jenjangSebelum()
    {
        return new ButirPktPemula;
    }

    protected function jenjangSesudah()
    {
        return new ButirPktMahir;
    }

    public function getAllBk($bk)
    {

        $jenjangSebelum = $this->jenjangSebelum()->select('ak')->where('nama_butir', $bk);

        $jenjangSesudah = $this->jenjangSesudah()->select('ak')->where('nama_butir', $bk);

       return self::select('ak')->where('nama_butir', $bk)->union($jenjangSebelum)->union($jenjangSesudah)->first();
        
    }

    public function getAllBkPenunjang($bk)
    {

        $jenjangSebelum = $this->jenjangSebelum()->select('ak')->where('nama_butir', 'like' , "%" . $bk . "%");

        $jenjangSesudah = $this->jenjangSesudah()->select('ak')->where('nama_butir', 'like' , "%" . $bk . "%");

       return self::select('ak')->where('nama_butir', 'like' , "%" . $bk . "%")->union($jenjangSebelum)->union($jenjangSesudah)->first();
        
    }
}
