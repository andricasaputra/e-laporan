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
     * @param int $year
     * @param int $month
     * @param int $wilker_id
     * @return void
     */
    public function scopeSortTableDetail($query, $year = null, $month = null, $wilker_id = null)
    {
        $year   = $year ?? date('Y');

        $query->whereYear('bulan', $year);

        if(isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if(isset($wilker_id) and $wilker_id != '') $query->whereWilkerId($wilker_id);

        return $query;
    }

    /**
     * Untuk menghitung pemakaian dokumen dalam bulan dan tanggal tertentu
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilker_id
     * @param bool $excel
     * @return collections
     */
    public function scopeCountPemakaianDokumen($query, $year, $month = null, $wilker_id = null, $excel =  false)
    {
        $query->selectRaw('dokumen, sum(total) as total')
              ->whereYear('bulan', $year);

        /*
        * untuk cek apakah pemakain dokumen digunakan pada laporan excel
        * untuk mendapatkan bulan terakhir apabila laporan dicetak dalam format tahunan
        * untuk laporan yang dipilih pada semua bulan
        */      
        if ($excel === true) {

            /*
            * jika semua bulan dipilih maka gunakan bulan ke 12 untuk dokumen yang digunakan
            */
            (isset($month) and $month != 'all') ? $query->whereMonth('bulan', $month) : $query->whereMonth('bulan', 12);

        /*
        * untuk menampilkan data pada statistik atau detail pemakaian dokumen saja
        */
        } else {

            if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        }

        if (isset($wilker_id) and $wilker_id != '') $query->whereWilkerId($wilker_id);
                     
        $query->groupBy('dokumen')->latest('total');
    }

    /**
     * Untuk menghitung total pemakaian dokumen dalam satu tahun
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilker_id
     * @return collections
     */
    public function scopeCountTotalPemakaianDokumen($query, $year, $month = null, $wilker_id = null)
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
        if (isset($month) and $month == 'all') {

            $end    = $date->copy()->endOfYear()->toDateString();

        /*
        * jika laporan yang dipilih pada bulan tertentu maka kita set tanggal akhir ke akhir bulan tsb
        */    
        } else {

            $end    = $date->copy()->endOfMonth()->toDateString();
        }

        $query->selectRaw('dokumen, sum(total) as total')
              ->whereBetween('bulan', [$start, $end]);

        if (isset($wilker_id) and $wilker_id != '') $query->whereWilkerId($wilker_id);
                     
        return $query->groupBy('dokumen')->latest('total');
    }

    /**
     * Untuk menghitung total PNBP
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilker_id
     * @return collections
     */
    public function scopeCountTotalPnbp($query, $year, $month = null, $wilker_id = null)
    {
        $query->selectRaw('sum(pnbp) as pnbp')  
              ->whereYear('bulan', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker_id) and $wilker_id != '') $query->whereWilkerId($wilker_id);
                     
        return $query->first();
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