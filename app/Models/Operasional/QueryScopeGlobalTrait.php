<?php

namespace App\Models\Operasional;

trait QueryScopeGlobalTrait
{
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
    */

    /**
     * Untuk Mensortir Detail Table (Table Global)
     *
     * @param $query
     * @param array $params
     * @return void
     */
    public function scopeSortTableDetail($query, array $params)
    {
        $query->whereYear('bulan', $params[0] ?? date('Y'));

        $query->when($params[1] && $params[1] != 'all', function ($query) use ($params) {

          return $query->whereMonth('bulan', $params[1]);

        });

        $query->when(! is_null($params[2]) && (int) $params[2] !== 1, function ($query) use ($params) {

          return $query->whereWilkerId($params[2]);

        });

        return $query;
    }

    /**
     * Untuk menghitung pemakaian dokumen dalam bulan dan tanggal tertentu
     *
     * @param $query
     * @param array $params
     * @param bool $excel
     * @return collections
     */
    public function scopeCountPemakaianDokumen($query, array $params, $excel =  false)
    {
        $query->selectRaw('dokumen, sum(jumlah) as total')
              ->whereYear('bulan', $params[0]);

        /*
        * untuk cek apakah pemakain dokumen digunakan pada laporan excel
        * untuk mendapatkan bulan terakhir apabila laporan dicetak dalam format tahunan
        * untuk laporan yang dipilih pada semua bulan
        */      
        if ($excel) {

            /*
            * jika semua bulan dipilih maka gunakan bulan ke 12 untuk dokumen yang digunakan
            */
            $query->when($params[1] && $params[1] != 'all', function ($query) use ($params) {

                return $query->whereMonth('bulan', $params[1]);

            }, function($query){

                return $query->whereMonth('bulan', 12);

            });

        /*
        * untuk menampilkan data pada statistik atau detail pemakaian dokumen saja
        */
        } else {

            $query->when($params[1] && $params[1] != 'all', function ($query) use ($params) {

                return $query->whereMonth('bulan', $params[1]);

            });

        }
       
        return  $query->when($params[2], function ($query, $wilker) {

                    return $query->whereWilkerId($wilker);

                })->groupBy('dokumen')->latest('total');
    }

    /**
     * Untuk menghitung total pemakaian dokumen dalam satu tahun
     *
     * @param $query
     * @param array $params
     * @return collections
     */
    public function scopeCountTotalPemakaianDokumen($query, array $params)
    {
        /*
        * init carbon set tanggal
        */
        $date   = \Carbon::createFromDate((int) $params[0], $params[1] == 'all' ? null : (int) $params[1], 1);

        /*
        * untuk menghitung dari awal tahun pemakaian
        */
        $start  = $date->copy()->startOfYear()->toDateString();

        /*
        * jika laporan yang dipilih semua bulan maka kita set tanggal akhir ke akhir tahun
        */
        if ($params[1] && $params[1] !== 'all') {
            
            $end = $date->copy()->endOfMonth()->toDateString();
        /*
        * jika laporan yang dipilih pada bulan tertentu maka kita set tanggal akhir ke akhir bulan tsb
        */    
        } else {

            $end = $date->copy()->endOfYear()->toDateString();
        }

        return  $query->selectRaw('dokumen, sum(jumlah) as total')
                      ->whereBetween('bulan', [$start, $end])
                      ->when($params[2], function ($query, $wilker) {

                    return $query->whereWilkerId($wilker);

                })->groupBy('dokumen')->latest('total');
    }

    /**
     * Untuk menghitung total PNBP
     *
     * @param $query
     * @param array $params
     * @return collections
     */
    public function scopeCountTotalPnbp($query, array $params)
    {
        return  $query->selectRaw('sum(pnbp) as pnbp')  
                      ->whereYear('bulan', $params[0])
                      ->when($params[1] && $params[1] != 'all', function ($query) use ($params) {

                    return $query->whereMonth('bulan', $params[1]);

                })->when($params[2], function ($query, $wilker) {

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