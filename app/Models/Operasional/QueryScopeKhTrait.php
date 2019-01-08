<?php

namespace App\Models\Operasional;

use Illuminate\Http\Request;

trait QueryScopeKhTrait
{
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

        if(isset($wilker_id)) $query->where('wilker_id', $wilker_id);

        return $query;
    }

    /**
     * Untuk Menghitung Total Frekuensi Dari KH
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilker_id
     * @return int
     */
    public function scopeCountFrekuensi($query, $year, $month = null, $wilker_id = null)
    {
        $query->selectRaw('sum(frekuensi) as frekuensi')
              ->whereNotNull('nama_mp')
              ->whereYear('bulan', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker_id)) $query->where('wilker_id', $wilker_id);
                     
        return $query->first();
    } 

    /**
     * Untuk Menghitung Total Volume Berdasarkan Satuan Dari KH
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilker_id
     * @return int
     */
    public function scopeCountVolume($query, $year, $month = null, $wilker_id = null)
    {
        $query->selectRaw('sum(volume) as volume, satuan')
              ->whereNotNull('nama_mp')
              ->whereYear('bulan', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker_id)) $query->where('wilker_id', $wilker_id);
                     
        return $query->groupBy('satuan');
    }

    /**
     * Untuk menghitung total pemakaian dokumen
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilker_id
     * @return collections
     */
    public function scopeCountPemakaianDokumen($query, $year, $month = null, $wilker_id = null)
    {
        $query->selectRaw('dokumen, sum(total) as total')
              ->whereNotNull('dokumen')
              ->whereYear('bulan', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker_id)) $query->where('wilker_id', $wilker_id);
                     
        return $query->groupBy('dokumen')->orderBy('total', 'desc');
    }

    /**
     * Untuk menghitung total frekuensi berdasarkan komoditas dan bulan
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilker_id
     * @return collections
     */
    public function scopeCountFrekuensiKomoditi($query, $year, $month = null, $wilker_id = null)
    {
        $query->selectRaw('year(bulan) as year, monthname(bulan) as bln, count(*) as data')
              ->whereNotNull('nama_mp')
              ->whereYear('bulan', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker_id)) $query->where('wilker_id', $wilker_id);

        return $query->groupBy('year', 'bln')->orderBy('bulan');
    }

    /**
     * Untuk menghitung rekapitulasi kegiatan dan grouping
     * berdasarkan nama komoditas dan bulan
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilker_id
     * @return collections
     */
    public function scopeCountRekapitulasi($query, $year, $month = null, $wilker_id = null)
    {   
        $query->selectRaw(' *, sum(volume) as volume, sum(pnbp) as pnbp, sum(frekuensi) as frekuensi')
              ->whereNotNull('nama_mp')
              ->whereYear('bulan', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker_id)) $query->where('wilker_id', $wilker_id);
           
        return $query->groupBy('nama_mp');
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

        if (isset($wilker_id)) $query->where('wilker_id', $wilker_id);
                     
        return $query->first();
    }

    /**
     * Untuk menghitung top 5 frekuensi berdasarkan komoditas dan bulan
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilker_id
     * @return collections
     */
    public function scopeTopFiveFrekuensiKomoditi($query, $year, $month = null, $wilker_id = null)
    {
        $query->selectRaw('nama_mp as name, sum(frekuensi) as data')
              ->whereNotNull('nama_mp') 
              ->whereYear('bulan', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker_id)) $query->where('wilker_id', $wilker_id);
           
        return $query->groupBy('name')->orderBy('data', 'desc')->limit(5);
    }

    /**
     * Mencari kota asal dan tujuan berdasarkan nama jenis MP, tahun, bulan dan wilker
     *
     * @param Request $request
     * @return collections
     */
    public function scopeGetDetailKotaByKomoditi($query, Request $request)
    {
        $mp         = str_replace('--', '/', $request->mp);
        $year       = $request->year;
        $month      = $request->month;
        $wilker_id  = (int) $request->wilker_id;

        $query->selectRaw(' asal,
                            tujuan,
                            kota_tuju, 
                            kota_asal, 
                            dok_pelepasan,
                            count(*) as total,
                            sum(jumlah) as volume,
                            satuan as satuan,
                            count(dok_pelepasan) as pemakaian_dokumen'
                          )
                          ->whereNotNull('nama_mp')
                          ->where('nama_mp', $mp);

        if ($wilker_id != null || $wilker_id != 0) $query->where('wilker_id', $wilker_id);
         
        if ($month !== null && $month !== 'all') $query->whereMonth('bulan', $month);
        
        $year === null ? $query->whereYear('bulan', date('Y')) : $query->whereYear('bulan', $year);

        return $query->groupBy('kota_asal', 'kota_tuju')->get();
    }

}