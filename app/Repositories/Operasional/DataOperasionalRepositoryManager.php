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
<<<<<<< HEAD
     * @var mixed
=======
     * @var collection
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public $dokelTotalVolume;

    /**
     * Untuk menyimpan data volume kegiatan domas
     *
<<<<<<< HEAD
     * @var mixed
=======
     * @var collection
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public $domasTotalVolume;

    /**
     * Untuk menyimpan data volume kegiatan ekspor
     *
<<<<<<< HEAD
     * @var mixed
=======
     * @var collection
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public $eksporTotalVolume;

    /**
     * Untuk menyimpan data volume kegiatan impor
     *
<<<<<<< HEAD
     * @var mixed
=======
     * @var collection
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public $imporTotalVolume;

    /**
     * Untuk menyimpan data volume kegiatan reeskpor
     *
<<<<<<< HEAD
     * @var mixed
=======
     * @var collection
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public $reeksporTotalVolume;

    /**
     * Untuk menyimpan data volume kegiatan serahterima
     *
<<<<<<< HEAD
     * @var mixed
=======
     * @var collection
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public $serahTerimaTotalVolume;

    /**
     * Untuk menyimpan data frekuensi kegiatan domas
     *
<<<<<<< HEAD
     * @var mixed
=======
     * @var collection
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public $frekuensiDomas;

    /**
     * Untuk menyimpan data frekuensi kegiatan dokel
     *
<<<<<<< HEAD
     * @var mixed
=======
     * @var collection
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public $frekuensiDokel;

    /**
     * Untuk menyimpan data frekuensi kegiatan ekspor
     *
<<<<<<< HEAD
     * @var mixed
=======
     * @var collection
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public $frekuensiEkspor;

    /**
     * Untuk menyimpan data frekuensi kegiatan impor
     *
<<<<<<< HEAD
     * @var mixed
=======
     * @var collection
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public $frekuensiImpor;

    /**
     * Untuk menyimpan data frekuensi kegiatan reekspor
     *
<<<<<<< HEAD
     * @var mixed
=======
     * @var collection
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public $frekuensiReekspor;

    /**
     * Untuk menyimpan data frekuensi kegiatan reekspor
     *
<<<<<<< HEAD
     * @var mixed
=======
     * @var collection
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public $frekuensiSerahTerima;

    /**
     * Untuk menyimpan data pnbp kegiatan domas
     *
<<<<<<< HEAD
     * @var mixed
=======
     * @var collection
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public $pnbpDomas;

    /**
     * Untuk menyimpan data pnbp kegiatan dokel
     *
<<<<<<< HEAD
     * @var mixed
=======
     * @var collection
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public $pnbpDokel;

    /**
     * Untuk menyimpan data pnbp kegiatan ekspor
     *
<<<<<<< HEAD
     * @var mixed
=======
     * @var collection
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public $pnbpEkspor;

    /**
     * Untuk menyimpan data pnbp kegiatan impor
     *
<<<<<<< HEAD
     * @var mixed
=======
     * @var collection
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public $pnbpImpor;

    /**
     * Untuk menyimpan data pnbp kegiatan impor
     *
<<<<<<< HEAD
     * @var mixed
=======
     * @var collection
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public $pnbpReekspor;

    /**
     * Untuk menyimpan data pnbp kegiatan impor
     *
<<<<<<< HEAD
     * @var mixed
=======
     * @var collection
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public $pnbpSerahTerima;

    /**
     * Untuk menyimpan data frekuensi per bulan dokel
     *
<<<<<<< HEAD
     * @var mixed
=======
     * @var collection
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public $frekuensiKomoditiDokel;

    /**
     * Untuk menyimpan data frekuensi per bulan domas
     *
<<<<<<< HEAD
     * @var mixed
=======
     * @var collection
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public $frekuensiKomoditiDomas;

    /**
     * Untuk menyimpan data frekuensi per bulan ekspor
     *
<<<<<<< HEAD
     * @var mixed
=======
     * @var collection
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public $frekuensiKomoditiEkspor;

    /**
     * Untuk menyimpan data frekuensi per bulan impor
     *
<<<<<<< HEAD
     * @var mixed
=======
     * @var collection
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public $frekuensiKomoditiImpor;

    /**
     * Untuk menyimpan data frekuensi per bulan reekspor
     *
<<<<<<< HEAD
     * @var mixed
=======
     * @var collection
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public $frekuensiKomoditiReekspor;

    /**
     * Untuk menyimpan data frekuensi per bulan serahterima
     *
<<<<<<< HEAD
     * @var mixed
=======
     * @var collection
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
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
<<<<<<< HEAD
     * @param null|\Illuminate\Http\Request
=======
     * @param  $year, $month, $wilker_id
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
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
<<<<<<< HEAD
     * @param \Illuminate\Http\Request
     * @return mixed
=======
     * @param Request $request
     * @return collections
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function getDetailKota(Request $request)
    {
        $model = $this->modelNamespace . $request->class;

        return $model::getDetailKotaByKomoditi($request);
    }

    /**
     * Menjadikan angka dengan format rupiah
     *
<<<<<<< HEAD
     * @param \Illuminate\Support\Collection
     * @return mixed
=======
     * @return collections
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public static function castNumberFormat($collections)
    {
        return $collections->map(function($value, $key){

            return collect($value)->map(function($val, $k){

                if ($k == 'pnbp') $val = rp($val);

                return $val;

            });
            
        });
    }

    /**
     * Rollback action laporan operasional |
     * Paggil Rollback Event
     *
<<<<<<< HEAD
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
=======
     * @param $request
     * @return void
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
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