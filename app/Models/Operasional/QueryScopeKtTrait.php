<?php

namespace App\Models\Operasional;

trait QueryScopeKtTrait
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
     * Untuk Menghitung Total Frekuensi Dari KT
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilker_id
     * @return int
     */
    public function scopeCountFrekuensi($query, $year, $month = null, $wilker_id = null)
    {
        $query->whereNotNull('nama_komoditas')->whereYear('bulan', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker_id)) $query->where('wilker_id', $wilker_id);
                     
        return $query->count();
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
        $query->selectRaw('dok_pelepasan as dokumen, count(dok_pelepasan) as total')
              ->whereNotNull('dok_pelepasan')
              ->whereYear('bulan', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker_id)) $query->where('wilker_id', $wilker_id);
                     
        return $query->groupBy('dok_pelepasan');
    }

    /**
     * Untuk menghitung total frekuensi berdasarkan komoditas
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
              ->whereNotNull('nama_komoditas')
              ->whereYear('bulan', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker_id)) $query->where('wilker_id', $wilker_id);

        return $query->groupBy('year', 'bln')->orderBy('bulan');
    }

    /**
     * Untuk menghitung rekapitulasi kegiatan dan grouping
     * berdasarkan nama komoditas
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilker_id
     * @return collections
     */
    public function scopeCountRekapitulasi($query, $year, $month = null, $wilker_id = null)
    {   
        $query->whereNotNull('nama_komoditas')->where('year', $year);

        if (isset($month) and $month != 'all') $query->where('month', $month);

        if (isset($wilker_id)) $query->where('wilker_id', $wilker_id);
           
        return $query;
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
              ->where('year', $year);

        if (isset($month) and $month != 'all') $query->where('month', $month);

        if (isset($wilker_id)) $query->where('wilker_id', $wilker_id);
                     
         return $query;
    }

    /**
     * Untuk menghitung top 5 frekuensi berdasarkan komoditas
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilker_id
     * @return collections
     */
    public function scopeTopFiveFrekuensiKomoditi($query, $year, $month = null, $wilker_id = null)
    {
        $query->select('nama_komoditas as name', 'frekuensi as data')
              ->whereNotNull('nama_komoditas') 
              ->where('year', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker_id)) $query->where('wilker_id', $wilker_id);
           
        return $query->orderBy('data', 'desc')->limit(5);
    }
    
}