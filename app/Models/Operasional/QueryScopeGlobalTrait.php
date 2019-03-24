<?php

namespace App\Models\Operasional;

use Carbon\Carbon;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

trait QueryScopeGlobalTrait
{
    //  Disable this trait if you're using shared hosting!
    use Cachable;

    /*
    |--------------------------------------------------------------------------
    | Info
    |--------------------------------------------------------------------------
    |
    | * Trait yang bersifat global, dan dapat dipakai pada ke dua buah trait yaitu
    |   QueryScopeKtTrait atau QueryScopeKhTrait -> bulan global scope laravel
    |   method - method pada class ini tetap memakai local scope saja
    |
    | * Digunakan untuk keperluan menampilkan data dari table views 
    |   untuk nama kolom yang sama saja
    |
    | * Hints : $arguments[0] => tahun, $arguments[1] => bulan, $arguments[2] => wilker id
    |
    */

    /**
     * Untuk Mensortir Detail Table (Table Global)
     *
     * @param $query
     * @param array $arguments
     * @return void
     */
    public function scopeSortTableDetail($query, array $arguments)
    {
        $query->whereYear('bulan', $arguments[0] ?? date('Y'));

        $query->when($arguments[1] && $arguments[1] != 'all', function ($query) use ($arguments) {

          return $query->whereMonth('bulan', $arguments[1]);

        });

        $query->when(! is_null($arguments[2]) && (int) $arguments[2] !== 1, function ($query) use ($arguments) {

          return $query->whereWilkerId($arguments[2]);

        });

        return $query;
    }

    /**
     * Untuk menghitung pemakaian dokumen dalam bulan dan tanggal tertentu
     *
     * @param $query
     * @param array $arguments
     * @param bool $excel
     * @return Illuminate\Support\Collection
     */
    public function scopeCountPemakaianDokumen($query, array $arguments, $excel =  false)
    {
        $query->selectRaw('dokumen, sum(jumlah) as total')
              ->whereYear('bulan', $arguments[0]);
        
        // Untuk cek apakah pemakain dokumen digunakan pada laporan excel
        if ($excel) {

            // Jika semua bulan dipilih maka gunakan bulan ke 12 untuk dokumen yang digunakan
            $query->when($arguments[1] && $arguments[1] != 'all', function ($query) use ($arguments) {

                return $query->whereMonth('bulan', $arguments[1]);

            }, function($query){

                return $query->whereMonth('bulan', 12);

            });

        // Jika tidak digunakan pada laporan excel maka
        // data dipakai pada halaman statistik atau detail pemakaian dokumen saja
        } else {

            $query->when($arguments[1] && $arguments[1] != 'all', function ($query) use ($arguments) {

                return $query->whereMonth('bulan', $arguments[1]);

            });

        }
       
        return  $query->when($arguments[2], function ($query, $wilker) {

                    return $query->whereWilkerId($wilker);

                })->groupBy('dokumen')->latest('total');
    }

    /**
     * Untuk menghitung total pemakaian dokumen dalam satu tahun
     *
     * @param $query
     * @param array $arguments
     * @return Illuminate\Support\Collection
     */
    public function scopeCountTotalPemakaianDokumen($query, array $arguments)
    {
      
        // Init carbon set tanggal
        $date   = Carbon::createFromDate((int) $arguments[0], $arguments[1] == 'all' ? null : (int) $arguments[1], 1);
  
        // Untuk menghitung dari awal tahun pemakaian
        $start  = $date->copy()->startOfYear()->toDateString();

        // Jika laporan yang dipilih semua bulan maka kita set tanggal akhir ke akhir tahun
        if ($arguments[1] && $arguments[1] !== 'all') {
            
            $end = $date->copy()->endOfMonth()->toDateString();
        
        // Jika laporan yang dipilih pada bulan tertentu maka kita set tanggal akhir ke akhir bulan tsb
        } else {

            $end = $date->copy()->endOfYear()->toDateString();
        }

        return  $query->selectRaw('dokumen, sum(jumlah) as total')
                      ->whereBetween('bulan', [$start, $end])
                      ->when($arguments[2], function ($query, $wilker) {

                    return $query->whereWilkerId($wilker);

                })->groupBy('dokumen')->latest('total');
    }

    /**
     * Untuk menghitung total PNBP
     *
     * @param $query
     * @param array $arguments
     * @return Illuminate\Support\Collection
     */
    public function scopeCountTotalPnbp($query, array $arguments)
    {
        return  $query->selectRaw('sum(pnbp) as pnbp')  
                      ->whereYear('bulan', $arguments[0])
                      ->when($arguments[1] && $arguments[1] != 'all', function ($query) use ($arguments) {

                    return $query->whereMonth('bulan', $arguments[1]);

                })->when($arguments[2], function ($query, $wilker) {

                    return $query->whereWilkerId($wilker);

                })->first();
    }

    /**
     * Untuk mendapatkan nama sebenarnya dari singkatan permohonan
     *
     * @param $query
     * @param string $value
     * @return string
     */
    public function scopeGetPermohonanFullName($query, $value)
    {
        switch ($value) {
            case 'dokel':
                $type = 'Domestik Keluar';
                break;
            case 'domas':
                $type = 'Domestik Masuk';
                break;
            case 'ekspor':
                $type = 'Ekspor';
                break;
            case 'impor':
                $type = 'Impor';
                break;
            case 'pembatalan_dok':
                $type = 'Pembatalan Dokumen';
                break;
            case 'reekspor':
                $type = 'Re Ekspor';
                break;
            case 'serahterima':
                $type = 'Serah Terima';
                break;
            default:
                $type = 'Data Operasional Tidak Ditemukan';
                break;
        }

        return $type;
    }
    
}