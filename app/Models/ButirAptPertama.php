<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ButirAptPertama extends Model
{
    use HasFactory;

    protected $table = 'bk_apt_pertama';
    protected $guarded = ['id'];

    protected function jenjangSesudah()
    {
        return new ButirAptMuda;
    }

    public function getAllBk($bk)
    {

        $jenjangSesudah = $this->jenjangSesudah()->select('ak')->where('nama_butir', $bk);

       return self::select('ak')->where('nama_butir', $bk)->union($jenjangSebelum)->union($jenjangSesudah)->first();
    }

    public function getAllBkPenunjang($bk)
    {

        $jenjangSesudah = $this->jenjangSesudah()->select('ak')->where('nama_butir', 'like' , "%" . $bk . "%");

       return self::select('ak')->where('nama_butir', 'like' , "%" . $bk . "%")->union($jenjangSesudah)->first();
        
    }
}
