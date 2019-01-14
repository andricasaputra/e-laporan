<?php

namespace App\Repositories\Operasional;

use App\Traits\Repository;
use Illuminate\Http\Request;
use App\Models\Operasional\LogInfo;
use App\Contracts\RepositoryInterface;
use App\Events\OperasionalRollbackEvent;
use App\Http\Controllers\RupiahController as Rupiah;

class DataOperasionalRepositoryManager implements RepositoryInterface
{
	use Repository;

    /**
     * Untuk menyimpan data volume kegiatan dokel
     *
     * @var collection
     */
    public $dokelTotalVolume;

    /**
     * Untuk menyimpan data volume kegiatan domas
     *
     * @var collection
     */
    public $domasTotalVolume;

    /**
     * Untuk menyimpan data volume kegiatan ekspor
     *
     * @var collection
     */
    public $eksporTotalVolume;

    /**
     * Untuk menyimpan data volume kegiatan impor
     *
     * @var collection
     */
    public $imporTotalVolume;

    /**
     * Untuk menyimpan data volume kegiatan reeskpor
     *
     * @var collection
     */
    public $reeksporTotalVolume;

    /**
     * Untuk menyimpan data volume kegiatan serahterima
     *
     * @var collection
     */
    public $serahTerimaTotalVolume;

    /**
     * Untuk menyimpan data frekuensi kegiatan domas
     *
     * @var collection
     */
    public $frekuensiDomas;

    /**
     * Untuk menyimpan data frekuensi kegiatan dokel
     *
     * @var collection
     */
    public $frekuensiDokel;

    /**
     * Untuk menyimpan data frekuensi kegiatan ekspor
     *
     * @var collection
     */
    public $frekuensiEkspor;

    /**
     * Untuk menyimpan data frekuensi kegiatan impor
     *
     * @var collection
     */
    public $frekuensiImpor;

    /**
     * Untuk menyimpan data frekuensi kegiatan reekspor
     *
     * @var collection
     */
    public $frekuensiReekspor;

    /**
     * Untuk menyimpan data frekuensi kegiatan reekspor
     *
     * @var collection
     */
    public $frekuensiSerahTerima;

    /**
     * Untuk menyimpan data pnbp kegiatan domas
     *
     * @var collection
     */
    public $pnbpDomas;

    /**
     * Untuk menyimpan data pnbp kegiatan dokel
     *
     * @var collection
     */
    public $pnbpDokel;

    /**
     * Untuk menyimpan data pnbp kegiatan ekspor
     *
     * @var collection
     */
    public $pnbpEkspor;

    /**
     * Untuk menyimpan data pnbp kegiatan impor
     *
     * @var collection
     */
    public $pnbpImpor;

    /**
     * Untuk menyimpan data pnbp kegiatan impor
     *
     * @var collection
     */
    public $pnbpReekspor;

    /**
     * Untuk menyimpan data pnbp kegiatan impor
     *
     * @var collection
     */
    public $pnbpSerahTerima;

    /**
     * Untuk menyimpan data frekuensi per bulan dokel
     *
     * @var collection
     */
    public $frekuensiKomoditiDokel;

    /**
     * Untuk menyimpan data frekuensi per bulan domas
     *
     * @var collection
     */
    public $frekuensiKomoditiDomas;

    /**
     * Untuk menyimpan data frekuensi per bulan ekspor
     *
     * @var collection
     */
    public $frekuensiKomoditiEkspor;

    /**
     * Untuk menyimpan data frekuensi per bulan impor
     *
     * @var collection
     */
    public $frekuensiKomoditiImpor;

    /**
     * Untuk menyimpan data frekuensi per bulan reekspor
     *
     * @var collection
     */
    public $frekuensiKomoditiReekspor;

    /**
     * Untuk menyimpan data frekuensi per bulan serahterima
     *
     * @var collection
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
     * @param  $year, $month, $wilker_id
     * @return void 
     */
    public function __construct($year = null, $month = null, $wilker_id = null)
    {
        $this->year         = $year ?? date('Y');

        $this->month        = $month;

        $this->wilker_id    = $wilker_id;

        $this->routeParams  = [$this->year, $this->month, $this->wilker_id];
    }

    /**
     * Mencari kota asal dan tujuan berdasarkan nama jenis MP, tahun, bulan dan wilker
     * Menggunakan model scope
     * 
     * @param Request $request
     * @return collections
     */
    public function getDetailKota(Request $request)
    {
        $model = $this->modelNamespace . $request->class;

        return $model::getDetailKotaByKomoditi($request);
    }

    /**
     * Menjadikan angka dengan format rupiah
     *
     * @return collections
     */
    public static function castNumberFormat($collections)
    {
        return $collections->map(function($value, $key){

            return collect($value)->map(function($val, $k){

                if ($k == 'pnbp') $val =  Rupiah::rp($val);

                return $val;

            });
            
        });
    }

    /**
     * Rollback action laporan operasional |
     * Paggil Rollback Event
     *
     * @param $request
     * @return void
     */
    public function rollback(Request $request)
    {
        $log = LogInfo::find($request->id);

        event( new OperasionalRollbackEvent($log) );

        $log->update([

            "status" => 1,
            "rolledback_at" => \Carbon::now()

        ]);
    }
}