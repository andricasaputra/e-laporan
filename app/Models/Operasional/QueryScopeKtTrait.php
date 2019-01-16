<?php

namespace App\Models\Operasional;

use Illuminate\Http\Request;

trait QueryScopeKtTrait
{
    use QueryScopeGlobalTrait;

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
        $query->selectRaw('sum(frekuensi) as frekuensi')
              ->whereNotNull('nama_komoditas')
              ->whereYear('bulan', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker_id) and $wilker_id != '') $query->where('wilker_id', $wilker_id);
                     
        return $query->first();
    } 

    /**
     * Untuk Menghitung Total Volume Berdasarkan Satuan Dari KT
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilker_id
     * @return int
     */
    public function scopeCountVolume($query, $year, $month = null, $wilker_id = null)
    {
        $query->selectRaw('sum(volume) as volume, sat_netto')
              ->whereNotNull('nama_komoditas')
              ->whereYear('bulan', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker_id) and $wilker_id != '') $query->where('wilker_id', $wilker_id);
                     
        return $query->groupBy('sat_netto');
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
              ->whereNotNull('nama_komoditas')
              ->whereYear('bulan', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker_id) and $wilker_id != '') $query->where('wilker_id', $wilker_id);

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
              ->whereNotNull('nama_komoditas')
              ->whereYear('bulan', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker_id) and $wilker_id != '') $query->where('wilker_id', $wilker_id);
           
        return $query->groupBy('nama_komoditas');
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
        $query->selectRaw('nama_komoditas as name, sum(frekuensi) as data')
              ->whereNotNull('nama_komoditas') 
              ->whereYear('bulan', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker_id) and $wilker_id != '') $query->where('wilker_id', $wilker_id);
           
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
                            sum(volume_netto) as volume,
                            sat_netto as satuan,
                            count(dok_pelepasan) as pemakaian_dokumen'
                          )
                          ->whereNotNull('nama_komoditas')
                          ->where('nama_komoditas', $mp);

        if ($wilker_id != null or $wilker_id != 0) $query->where('wilker_id', $wilker_id);
         
        if ($month !== null and $month !== 'all') $query->whereMonth('bulan', $month);

        $year === null ? $query->whereYear('bulan', date('Y')) : $query->whereYear('bulan', $year);

        return $query->groupBy('kota_asal', 'kota_tuju')->get();
    }

    /**
     * Untuk mendownload Excel File laporan operasional 
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilker_id
     * @return collections
     */
    public function scopeLaporanOperasional($query, $year, $month = null, $wilker_id = null)
    {
        $query->select(
             'no_permohonan',
             'no_aju',
             'tanggal_permohonan',
             'jenis_permohonan',
             'nama_pemohon',
             'nama_pengirim',
             'alamat_pengirim',
             'nama_penerima',
             'alamat_penerima',
             'jumlah_kemasan',
             'kota_asal',
             'asal',
             'kota_tuju',
             'tujuan',
             'port_asal',
             'port_tuju',
             'moda_alat_angkut_terakhir',
             'tipe_alat_angkut_terakhir',
             'nama_alat_angkut_terakhir',
             'status_internal',
             'lokasi_mp',
             'tempat_produksi',
             'nama_tempat_pelaksanaan',
             'peruntukan',
             'dok_pelepasan',
             'nomor_dok_pelepasan',
             'tanggal_pelepasan',
             'kode_hs',
             'nama_komoditas',
             'nama_komoditas_en',
             'volume_netto',
             'sat_netto',
             'volume_bruto',
             'sat_bruto',
             'no_seri',
             'total_pnbp'
         )->whereYear('bulan', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker_id) and $wilker_id != '' and $wilker_id != 1) $query->whereWilkerId($wilker_id);

        return $query->whereNotNull('no_permohonan')->orderBy('id', 'asc')->get();
    }

    /**
     * Untuk mendownload Excel File laporan rekapitulasi komoditi 
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilker_id
     * @return collections
     */
    public function scopeLaporanRekapitulasiKomoditi($query, $year, $month = null, $wilker_id = null)
    {
        $query->selectRaw(
             '  wilker_id,    
                nama_komoditas,
                sum(volume_netto) as volume,
                sat_netto,
                count(*) as frekuensi,
                kota_asal,
                asal,
                kota_tuju,
                tujuan '
         )->whereYear('bulan', $year);

        if (isset($month) and $month != 'all') $query->whereMonth('bulan', $month);

        if (isset($wilker_id) and $wilker_id != '' and $wilker_id != 1) $query->whereWilkerId($wilker_id);

        return $query->with('wilker')
                     ->groupBy('wilker_id', 'nama_komoditas', 'kota_asal', 'kota_tuju')
                     ->orderBy('wilker_id', 'asc')
                     ->get();
    }
    
}