<?php

namespace App\Models\Operasional;

use Illuminate\Http\Request;

trait QueryScopeKhTrait
{
    use QueryScopeGlobalTrait;

    /**
     * Untuk Menghitung Total Frekuensi Dari KH Berdasarkan permohonan
     * Kita ambil data bukan dari tabel view melainkan dari tabel utama
     *
     * @param $query
     * @param array $params
     * @return int
     */
    public function scopeCountFrekuensiByPermohonan($query, array $params)
    {
        $query->selectRaw('count(*) as frekuensi')
              ->where('no_permohonan', '!=', 'IDEM')
              ->where('no_permohonan', '!=', '')
              ->whereNotNull('nama_mp')
              ->whereYear('bulan', $params[0]);

        $query->when($params[1] && $params[1] != 'all', function ($query) use ($params) {

            return $query->whereMonth('bulan', $params[1]);

        })->when($params[2], function ($query, $wilker) {

            return $query->whereWilkerId($wilker);

        });
                     
        return $query->first();
    } 

    /**
     * Untuk Menghitung Total Volume Berdasarkan Satuan Dari KH
     *
     * @param $query
     * @param array $params
     * @return int
     */
    public function scopeCountVolume($query, array $params)
    {
        $query->selectRaw('sum(volume) as volume, satuan')
              ->whereNotNull('nama_mp')
              ->whereYear('bulan', $params[0]);

        $query->when($params[1] && $params[1] != 'all', function ($query) use ($params) {

            return $query->whereMonth('bulan', $params[1]);

        })->when($params[2], function ($query, $wilker) {

            return $query->whereWilkerId($wilker);

        });
                     
        return $query->groupBy('satuan');
    }

    /**
     * Untuk menghitung total frekuensi berdasarkan komoditas dan bulan
     *
     * @param $query
     * @param array $params
<<<<<<< HEAD
     * @return Illuminate\Support\Collection
=======
     * @return collections
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function scopeCountFrekuensiByKomoditi($query, array $params)
    {
        $query->selectRaw('year(bulan) as year, monthname(bulan) as bln, sum(frekuensi) as data')
              ->whereNotNull('nama_mp')
              ->whereYear('bulan', $params[0]);

        $query->when($params[1] && $params[1] != 'all', function ($query) use ($params) {

            return $query->whereMonth('bulan', $params[1]);

        })->when($params[2], function ($query, $wilker) {

            return $query->whereWilkerId($wilker);

        });

        return $query->groupBy('year', 'bln')->oldest('bulan');
    }

    /**
     * Untuk menghitung rekapitulasi kegiatan dan grouping
     * berdasarkan nama komoditas dan bulan
     *
     * @param $query
     * @param array $params
<<<<<<< HEAD
     * @return Illuminate\Support\Collection
     */
    public function scopeCountRekapitulasi($query, array $params)
    {   
        $query->selectRaw(' *, sum(volume) as volume, sum(pnbp) as pnbp, sum(frekuensi) as frekuensi, nama_mp')
=======
     * @return collections
     */
    public function scopeCountRekapitulasi($query, array $params)
    {   
        $query->selectRaw(' *, sum(volume) as volume, sum(pnbp) as pnbp, sum(frekuensi) as frekuensi')
              ->whereNotNull('nama_mp')
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
              ->whereYear('bulan', $params[0]);

        $query->when($params[1] && $params[1] != 'all', function ($query) use ($params) {

            return $query->whereMonth('bulan', $params[1]);

        })->when($params[2], function ($query, $wilker) {

            return $query->whereWilkerId($wilker);

        });
           
        return $query->groupBy('nama_mp');
    }

    /**
     * Untuk menghitung top 5 frekuensi berdasarkan komoditas dan bulan
     *
     * @param $query
     * @param array $params
<<<<<<< HEAD
     * @return Illuminate\Support\Collection
=======
     * @return collections
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function scopeTopFiveFrekuensiKomoditi($query, array $params)
    {
        $query->selectRaw('nama_mp as name, sum(frekuensi) as data')
              ->whereNotNull('nama_mp') 
              ->whereYear('bulan', $params[0]);

        $query->when($params[1] && $params[1] != 'all', function ($query) use ($params) {

            return $query->whereMonth('bulan', $params[1]);

        })->when($params[2], function ($query, $wilker) {

            return $query->whereWilkerId($wilker);

        });
           
        return $query->groupBy('name')->latest('data')->limit(5);
    }

    /**
     * Mencari kota asal dan tujuan berdasarkan nama jenis MP, tahun, bulan dan wilker
     *
     * @param Request $request
<<<<<<< HEAD
     * @return Illuminate\Support\Collection
=======
     * @return collections
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
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
                            sum(jumlah) as volume,
                            satuan as satuan,
                            count(dok_pelepasan) as pemakaian_dokumen'
                          )
                          ->whereNotNull('nama_mp')
                          ->whereNamaMp($mp);

        $query->when($month && $month != 'all', function ($query) use ($month) {

            return $query->whereMonth('bulan', $month);

        })->when($wilkerId, function ($query, $wilker) {

            return $query->whereWilkerId($wilker);

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
     * @param array $params
<<<<<<< HEAD
     * @return Illuminate\Support\Collection
=======
     * @return collections
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function scopeLaporanOperasional($query, array $params)
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
             'peruntukan',
             'dok_pelepasan',
             'nomor_dok_pelepasan',
             'tanggal_pelepasan',
             'jenis_mp',
             'kelas_mp',
             'kode_hs',
             'nama_mp',
             'nama_latin',
             'jantan',
             'betina',
             'jumlah',
             'satuan',
             'no_seri',
             'total_pnbp'
         )->whereYear('bulan', $params[0]);

        $query->when($params[1] && $params[1] != 'all', function ($query) use ($params) {

            return $query->whereMonth('bulan', $params[1]);

        })->when($params[2], function ($query, $wilker) {

            return $query->whereWilkerId($wilker);

        });

        return $query->whereNotNull('no_permohonan')->oldest('id')->get();
    }

    /**
     * Untuk mendownload Excel File laporan rekapitulasi komoditi 
     *
     * @param $query
     * @param array $params
<<<<<<< HEAD
     * @return Illuminate\Support\Collection
=======
     * @return collections
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function scopeLaporanRekapitulasiKomoditi($query, array $params)
    {
        $query->select(
             'wilker_id', 'nama_mp', 'kota_asal', 'kota_tuju', 'asal', 'tujuan', 'jumlah', 'satuan'
        )->whereYear('bulan', $params[0]);

        $query->when($params[1] && $params[1] != 'all', function ($query) use ($params) {

            return $query->whereMonth('bulan', $params[1]);

        })->when($params[2], function ($query, $wilker) {

            return $query->whereWilkerId($wilker);

        });

        return $query->with('wilker')->oldest('wilker_id')->orderBy('nama_mp', 'asc')->get();
    }

}