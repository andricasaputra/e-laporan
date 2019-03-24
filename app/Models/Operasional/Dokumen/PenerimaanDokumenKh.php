<?php

namespace App\Models\Operasional\Dokumen;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PenerimaanDokumenKh extends Model
{
    use QueryScopeDokumen;

    protected $table 	= 'penerimaan_dokumen_kh';
    protected $guarded 	= ['id', 'created_at', 'updated_at'];
    protected $with     = ['wilker', 'user', 'dokumen'];

    /**
     * Untuk menghitung pemakaian dokumen dalam bulan dan tanggal tertentu
     *
     * @param $query
     * @param int|bool $year
     * @param int|bool $month
     * @param int|bool $wilkerId
     * @param bool $excel
     * @return Illuminate\Support\Collections
     */
    public function scopeCountPenerimaanDokumen($query, $year, $month = false, $wilkerId = false, $excel = false)
    {
        $query->selectRaw('dokumen_id, sum(jumlah) as total')
              ->whereYear('created_at', $year);

        // Untuk cek apakah pemakain dokumen digunakan pada laporan excel   
        if ($excel) {

            // Jika semua bulan dipilih maka gunakan bulan ke 12 untuk dokumen yang digunakan
            $query->when($month && $month != 'all', function ($query) use ($month) {

                return $query->whereMonth('created_at', $month);

            }, function($query){

                return $query->whereMonth('created_at', 12);

            });
        
        // Untuk menampilkan data pada statistik atau detail pemakaian dokumen saja
        } else {

            $query->when($month && $month != 'all', function ($query) use ($month) {

                return $query->whereMonth('created_at', $month);

            });

        }

        return  $query->when($wilkerId, function ($query, $wilkerId) {

                    return $query->whereWilkerId($wilkerId);

                })->whereIn('dokumen_id', $this->setDokumenKh())
                  ->groupBy('dokumen_id')->get();
    }

    /**
     * Untuk menghitung total pemakaian dokumen dalam satu tahun
     *
     * @param $query
     * @param int|bool $year
     * @param int|bool $month
     * @param int|bool $wilkerId
     * @return Illuminate\Support\Collections
     */
    public function scopeCountTotalPemakaianDokumen($query, $year, $month = false, $wilkerId = false)
    {
        // Init carbon set tanggal
        $date   = Carbon::createFromDate((int) $year, $month == 'all' ? null : (int) $month, 1);

        // Untuk menghitung dari awal tahun pemakaian
        $start  = $date->copy()->startOfYear()->toDateString();
   
        // Jika laporan yang dipilih semua bulan maka kita set tanggal akhir ke akhir tahun
        if ($month && $month != 'all') {

            $end = $date->copy()->endOfYear()->toDateString();

        // Jika laporan yang dipilih pada bulan tertentu maka kita set tanggal akhir ke akhir bulan tsb  
        } else {

            $end = $date->copy()->endOfMonth()->toDateString();
        }
        
        return  $query->selectRaw('dokumen_id, sum(jumlah) as total')
                      ->whereBetween('created_at', [$start, $end])
                      ->when($wilkerId ?? false, function ($query, $wilkerId) {

                    return $query->whereWilkerId($wilkerId);

                })->whereIn('dokumen_id', $this->setDokumenKh())
                  ->groupBy('dokumen_id')->get();
    }
}
