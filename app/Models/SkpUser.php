<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkpUser extends Model
{
    use HasFactory;

    protected $table = 'skp_user';
    protected $guarded = ['id'];
    protected $appends = ['bk'];

    public function pegawai()
    {
        return $this->belongsTo(MasterPegawai::class, 'user_id', 'user_id');
    }

    /**
     * Untuk Mensortir Detail Table (Table Global)
     *
     * @param $query
     * @param array $arguments
     * @return void
     */
    public function scopeSortTableDetail($query, array $arguments)
    {
        $query->whereYear('tanggal', $arguments[0] ?? date('Y'));

        $query->when($arguments[1] && $arguments[1] != 'all', function ($query) use ($arguments) {

          return $query->whereMonth('tanggal', $arguments[1]);

        });

        return $query;
    }

    public function getBkAttribute()
    {
        $ex = explode("-", $this->attributes['butir_kegiatan']);

        $bk = trim($ex[1]);

        if (auth()->user()->pegawai->jabatan == 'PEMERIKSA KARANTINA TUMBUHAN TERAMPIL') {

            $jenjangSebelum = ButirPktPemula::select('ak')->where('nama_butir', $bk);
 
            $jenjangSesudah = ButirPktMahir::select('ak')->where('nama_butir', $bk);

           return ButirPktTerampil::select('ak')->where('nama_butir', $bk)->union($jenjangSebelum)->union($jenjangSesudah)->first();
        }
    }

}
