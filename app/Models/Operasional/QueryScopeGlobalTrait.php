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
     * @param int|bool $year
     * @param int|bool $month
     * @param int|bool $wilkerId
     * @return void
     */
    public function scopeSortTableDetail($query, $year = null, $month = false, $wilkerId = false)
    {
        return  $query->whereYear('bulan', $year ?? date('Y'))
                      ->when($month && $month != 'all', function ($query) use ($month) {

                        return $query->whereMonth('bulan', $month);

                    })->when($wilkerId, function ($query, $wilkerId) {

                        return $query->whereWilkerId($wilkerId);

                    });
    }

    /**
     * Untuk menghitung pemakaian dokumen dalam bulan dan tanggal tertentu
     *
     * @param $query
     * @param int|bool $year
     * @param int|bool $month
     * @param int|bool $wilkerId
     * @param bool $excel
     * @return collections
     */
    public function scopeCountPemakaianDokumen($query, $year, $month = false, $wilkerId = false, $excel =  false)
    {
        $query->selectRaw('dokumen, sum(total) as total')
              ->whereYear('bulan', $year);

        /*
        * untuk cek apakah pemakain dokumen digunakan pada laporan excel
        * untuk mendapatkan bulan terakhir apabila laporan dicetak dalam format tahunan
        * untuk laporan yang dipilih pada semua bulan
        */      
        if ($excel) {

            /*
            * jika semua bulan dipilih maka gunakan bulan ke 12 untuk dokumen yang digunakan
            */

            $query->when($month && $month != 'all', function ($query) use ($month) {

                return $query->whereMonth('bulan', $month);

            }, function($query){

                return $query->whereMonth('bulan', 12);

            });

        /*
        * untuk menampilkan data pada statistik atau detail pemakaian dokumen saja
        */
        } else {

            $query->when($month && $month != 'all', function ($query) use ($month) {

                return $query->whereMonth('bulan', $month);

            });

        }

        return  $query->when($wilkerId, function ($query, $wilkerId) {

                    return $query->whereWilkerId($wilkerId);

                })->groupBy('dokumen')->latest('total');
    }

    /**
     * Untuk menghitung total pemakaian dokumen dalam satu tahun
     *
     * @param $query
     * @param int|bool $year
     * @param int|bool $month
     * @param int|bool $wilkerId
     * @return collections
     */
    public function scopeCountTotalPemakaianDokumen($query, $year, $month = false, $wilkerId = false)
    {
        /*
        * init carbon set tanggal
        */
        $date   = \Carbon::createFromDate((int) $year, $month == 'all' ? null : (int) $month, 1);

        /*
        * untuk menghitung dari awal tahun pemakaian
        */
        $start  = $date->copy()->startOfYear()->toDateString();

        /*
        * jika laporan yang dipilih semua bulan maka kita set tanggal akhir ke akhir tahun
        */
        if ($month && $month != 'all') {

            $end    = $date->copy()->endOfYear()->toDateString();

        /*
        * jika laporan yang dipilih pada bulan tertentu maka kita set tanggal akhir ke akhir bulan tsb
        */    
        } else {

            $end    = $date->copy()->endOfMonth()->toDateString();
        }

        return  $query->selectRaw('dokumen, sum(total) as total')
                      ->whereBetween('bulan', [$start, $end])
                      ->when($wilkerId, function ($query, $wilkerId) {

                    return $query->whereWilkerId($wilkerId);

                })->groupBy('dokumen')->latest('total');
    }

    /**
     * Untuk menghitung total PNBP
     *
     * @param $query
     * @param int|bool $year
     * @param int|bool $month
     * @param int|bool $wilkerId
     * @return collections
     */
    public function scopeCountTotalPnbp($query, $year, $month = false, $wilkerId = false)
    {
        return  $query->selectRaw('sum(pnbp) as pnbp')  
                      ->whereYear('bulan', $year)
                      ->when($month && $month != 'all', function ($query) use ($month) {

                    return $query->whereMonth('bulan', $month);

                })->when($wilkerId, function ($query, $wilkerId) {

                    return $query->whereWilkerId($wilkerId);

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