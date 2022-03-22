<?php

namespace App\Repositories\Operasional;

use App\Traits\Repository;
use Illuminate\Http\Request;
use App\Models\Operasional\LogInfo;
use App\Contracts\RepositoryInterface;
use App\Events\OperasionalRollbackEvent;

class DataOperasionalRepositoryManager implements RepositoryInterface
{
	use Repository;

    /**
     * Untuk menyimpan data volume kegiatan dokel
     *
     * @var mixed
     */
    public $dokelTotalVolume;

    /**
     * Untuk menyimpan data volume kegiatan domas
     *
     * @var mixed
     */
    public $domasTotalVolume;

    /**
     * Untuk menyimpan data volume kegiatan ekspor
     *
     * @var mixed
     */
    public $eksporTotalVolume;

    /**
     * Untuk menyimpan data volume kegiatan impor
     *
     * @var mixed
     */
    public $imporTotalVolume;

    /**
     * Untuk menyimpan data volume kegiatan reeskpor
     *
     * @var mixed
     */
    public $reeksporTotalVolume;

    /**
     * Untuk menyimpan data volume kegiatan serahterima
     *
     * @var mixed
     */
    public $serahTerimaTotalVolume;

    /**
     * Untuk menyimpan data frekuensi kegiatan domas
     *
     * @var mixed
     */
    public $frekuensiDomas;

    /**
     * Untuk menyimpan data frekuensi kegiatan dokel
     *
     * @var mixed
     */
    public $frekuensiDokel;

    /**
     * Untuk menyimpan data frekuensi kegiatan ekspor
     *
     * @var mixed
     */
    public $frekuensiEkspor;

    /**
     * Untuk menyimpan data frekuensi kegiatan impor
     *
     * @var mixed
     */
    public $frekuensiImpor;

    /**
     * Untuk menyimpan data frekuensi kegiatan reekspor
     *
     * @var mixed
     */
    public $frekuensiReekspor;

    /**
     * Untuk menyimpan data frekuensi kegiatan reekspor
     *
     * @var mixed
     */
    public $frekuensiSerahTerima;

    /**
     * Untuk menyimpan data pnbp kegiatan domas
     *
     * @var mixed
     */
    public $pnbpDomas;

    /**
     * Untuk menyimpan data pnbp kegiatan dokel
     *
     * @var mixed
     */
    public $pnbpDokel;

    /**
     * Untuk menyimpan data pnbp kegiatan ekspor
     *
     * @var mixed
     */
    public $pnbpEkspor;

    /**
     * Untuk menyimpan data pnbp kegiatan impor
     *
     * @var mixed
     */
    public $pnbpImpor;

    /**
     * Untuk menyimpan data pnbp kegiatan impor
     *
     * @var mixed
     */
    public $pnbpReekspor;

    /**
     * Untuk menyimpan data pnbp kegiatan impor
     *
     * @var mixed
     */
    public $pnbpSerahTerima;

    /**
     * Untuk menyimpan data frekuensi per bulan dokel
     *
     * @var mixed
     */
    public $frekuensiKomoditiDokel;

    /**
     * Untuk menyimpan data frekuensi per bulan domas
     *
     * @var mixed
     */
    public $frekuensiKomoditiDomas;

    /**
     * Untuk menyimpan data frekuensi per bulan ekspor
     *
     * @var mixed
     */
    public $frekuensiKomoditiEkspor;

    /**
     * Untuk menyimpan data frekuensi per bulan impor
     *
     * @var mixed
     */
    public $frekuensiKomoditiImpor;

    /**
     * Untuk menyimpan data frekuensi per bulan reekspor
     *
     * @var mixed
     */
    public $frekuensiKomoditiReekspor;

    /**
     * Untuk menyimpan data frekuensi per bulan serahterima
     *
     * @var mixed
     */
    public $frekuensiKomoditiSerahTerima;

    /**
     * Untuk menyimpan parameter tahun dari url
     *
     * @var int
     */
    public $year;

    /**
     * Untuk menyimpan parameter bulan dari url
     *
     * @var int / nullable
     */
    public $month = null;

    /**
     * Untuk menyimpan parameter wilker_id dari url
     *
     * @var int / nullable
     */
    public $wilker_id = null;

    /**
     * Untuk menyatukan semua parameter yang dibutuhkan oleh route menjadi 1
     *
     * @var array
     */
    public $routeParams;

    /**
     * Untuk menyimpan model namespace
     *
     * @var string
     */
    public $modelNamespace = 'App\\Models\\Operasional\\';

    /**
     * Untuk set semua property yang ada di class ini 
     * -> dipanggil pada constructor class HomeKtController atau HomeKhController
     *
     * @param null|\Illuminate\Http\Request
     * @return void 
     */
    public function __construct(?Request $request)
    {
        $this->year         = $request->year ?? date('Y');

        $this->month        = $request->month ?? false;

        $this->wilker_id    = $request->wilker_id ?? false;

        $this->routeParams  = [$this->year, $this->month, $this->wilker_id];
    }

    /**
     * Mencari kota asal dan tujuan berdasarkan nama jenis MP, tahun, bulan dan wilker
     * Menggunakan model scope
     * 
     * @param \Illuminate\Http\Request
     * @return mixed
     */
    public function getDetailKota(Request $request)
    {
        $model = $this->modelNamespace . $request->class;

        return $model::getDetailKotaByKomoditi($request);
    }

    /**
     * Menjadikan angka dengan format rupiah
     *
     * @param \Illuminate\Support\Collection
     * @return mixed
     */
    public static function castNumberFormat($collections)
    {
        return $collections->map(function($value, $key){

            return collect($value)->map(function($val, $k){

                if ($k == 'pnbp') {
                    $val = rp($val);
                } 

                return $val;

            });
            
        });
    }

    /**
     * Rollback action laporan operasional |
     * Paggil Rollback Event
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function rollback(Request $request)
    {
        $log = LogInfo::find($request->id);
       
        event( new OperasionalRollbackEvent($log) );

        $log->update([

            "status" => 1,
            "rolledback_at" => now()

        ]);
    }
}