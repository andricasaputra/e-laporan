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
     * @param int $wilkerId
     * @return int
     */
    public function scopeCountFrekuensi($query, $year, $month = false, $wilkerId = false)
    {
        $query->selectRaw('sum(frekuensi) as frekuensi')
              ->whereNotNull('nama_komoditas')
              ->whereYear('bulan', $year);

        $query->when($month && $month != 'all', function ($query) use ($month) {

            return $query->whereMonth('bulan', $month);

        })->when($wilkerId, function ($query, $wilkerId) {

            return $query->whereWilkerId($wilkerId);

        });
                     
        return $query->first();
    } 

    /**
     * Untuk Menghitung Total Volume Berdasarkan Satuan Dari KT
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilkerId
     * @return int
     */
    public function scopeCountVolume($query, $year, $month = false, $wilkerId = false)
    {
        $query->selectRaw('sum(volume) as volume, sat_netto')
              ->whereNotNull('nama_komoditas')
              ->whereYear('bulan', $year);

        $query->when($month && $month != 'all', function ($query) use ($month) {

            return $query->whereMonth('bulan', $month);

        })->when($wilkerId, function ($query, $wilkerId) {

            return $query->whereWilkerId($wilkerId);

        });
                     
        return $query->groupBy('sat_netto');
    }

    /**
     * Untuk menghitung total frekuensi berdasarkan komoditas dan bulan
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilkerId
     * @return collections
     */
    public function scopeCountFrekuensiKomoditi($query, $year, $month = false, $wilkerId = false)
    {
        $query->selectRaw('year(bulan) as year, monthname(bulan) as bln, count(*) as data')
              ->whereNotNull('nama_komoditas')
              ->whereYear('bulan', $year);

        $query->when($month && $month != 'all', function ($query) use ($month) {

            return $query->whereMonth('bulan', $month);

        })->when($wilkerId, function ($query, $wilkerId) {

            return $query->whereWilkerId($wilkerId);

        });

        return $query->groupBy('year', 'bln')->oldest('bulan');
    }

    /**
     * Untuk menghitung rekapitulasi kegiatan dan grouping
     * berdasarkan nama komoditas dan bulan
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilkerId
     * @return collections
     */
    public function scopeCountRekapitulasi($query, $year, $month = false, $wilkerId = false)
    {   
        $query->selectRaw(' *, sum(volume) as volume, sum(pnbp) as pnbp, sum(frekuensi) as frekuensi')
              ->whereNotNull('nama_komoditas')
              ->whereYear('bulan', $year);

        $query->when($month && $month != 'all', function ($query) use ($month) {

            return $query->whereMonth('bulan', $month);

        })->when($wilkerId, function ($query, $wilkerId) {

            return $query->whereWilkerId($wilkerId);

        });
           
        return $query->groupBy('nama_komoditas');
    }

    /**
     * Untuk menghitung top 5 frekuensi berdasarkan komoditas dan bulan
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilkerId
     * @return collections
     */
    public function scopeTopFiveFrekuensiKomoditi($query, $year, $month = false, $wilkerId = false)
    {
        $query->selectRaw('nama_komoditas as name, sum(frekuensi) as data')
              ->whereNotNull('nama_komoditas') 
              ->whereYear('bulan', $year);

        $query->when($month && $month != 'all', function ($query) use ($month) {

            return $query->whereMonth('bulan', $month);

        })->when($wilkerId, function ($query, $wilkerId) {

            return $query->whereWilkerId($wilkerId);

        });
           
        return $query->groupBy('name')->latest('data')->limit(5);
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
        $year       = $request->year ?? false;
        $month      = $request->month ?? false;
        $wilkerId   = $request->wilker_id ?? false;

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
                          ->whereNamaKomoditas($mp);

        $query->when($month && $month != 'all', function ($query) use ($month) {

            return $query->whereMonth('bulan', $month);

        })->when($wilkerId, function ($query, $wilkerId) {

            return $query->whereWilkerId($wilkerId);

        })->when($year, function ($query, $year) {

            return $query->whereYear('bulan', $year);

        }, function($query){

            return $query->whereYear('bulan', date('Y'));

        });

        return $query->groupBy('kota_asal', 'kota_tuju')->get();
    }

    /**
     * Untuk mendownload Excel File laporan operasional 
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilkerId
     * @return collections
     */
    public function scopeLaporanOperasional($query, $year, $month = false, $wilkerId = false)
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

        $query->when($month && $month != 'all', function ($query) use ($month) {

            return $query->whereMonth('bulan', $month);

        })->when($wilkerId, function ($query, $wilkerId) {

            return $query->whereWilkerId($wilkerId);

        });

        return $query->whereNotNull('no_permohonan')->oldest('id')->get();
    }

    /**
     * Untuk mendownload Excel File laporan rekapitulasi komoditi 
     *
     * @param $query
     * @param int $year
     * @param int $month
     * @param int $wilkerId
     * @return collections
     */
    public function scopeLaporanRekapitulasiKomoditi($query, $year, $month = false, $wilkerId = false)
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

        $query->when($month && $month != 'all', function ($query) use ($month) {

            return $query->whereMonth('bulan', $month);

        })->when($wilkerId, function ($query, $wilkerId) {

            return $query->whereWilkerId($wilkerId);

        });

        return $query->with('wilker')
                     ->groupBy('wilker_id', 'nama_komoditas', 'kota_asal', 'kota_tuju')
                     ->oldest('wilker_id')
                     ->get();
    }
    
}