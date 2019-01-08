<?php 

namespace App\Repositories\Operasional;

use App\Traits\Repository;
use Illuminate\Http\Request;
use App\Models\Operasional\LogInfo;
use App\Contracts\RepositoryInterface;
use App\Events\OperasionalRollbackEvent;
use App\Models\Operasional\PembatalanDokKh;
use App\Http\Controllers\RupiahController as Rupiah;
use App\Models\Operasional\PemakaianDokumenKh as DokumenKh;
use App\Models\Operasional\RekapitulasiKomoditiDokelKh as RekapDokelKh;
use App\Models\Operasional\RekapitulasiKomoditiDomasKh as RekapDomasKh;
use App\Models\Operasional\RekapitulasiKomoditiImporKh as RekapImporKh;
use App\Models\Operasional\RekapitulasiKomoditiEksporKh as RekapEksporKh;

class DataOperasionalKhRepository implements RepositoryInterface
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
     * -> dipanggil pada constructor class HomeKhController
     *
     * @param  $year, $month, $wilker_id
     * @return void 
     */
    public function setDateAndWilker($year = null, $month = null, $wilker_id = null)
    {
        $this->year         = $year ?? date('Y');

        $this->month        = $month;

        $this->wilker_id    = $wilker_id;

        $this->routeParams  = [$this->year, $this->month, $this->wilker_id];
    }

    /**
     * Mengatur total frekuensi berdasakan jenis Kegiatan |
     * memakai scope local pada Model
     *
     * @return array
     */
    public function totalFrekuensiPerKegiatan()
    {
        $this->frekuensiDomas   =   RekapDomasKh::countFrekuensi(
                                        $this->year, $this->month, $this->wilker_id
                                    )->frekuensi;

        $this->frekuensiDokel   =   RekapDokelKh::countFrekuensi(
                                        $this->year, $this->month, $this->wilker_id
                                    )->frekuensi;

        $this->frekuensiEkspor  =   RekapEksporKh::countFrekuensi(
                                        $this->year, $this->month, $this->wilker_id
                                    )->frekuensi;

        $this->frekuensiImpor   =   RekapImporKh::countFrekuensi(
                                        $this->year, $this->month, $this->wilker_id
                                    )->frekuensi;

        return $this;
    }

    /**
     * Mengatur total volume komoditi per satuan |
     * memakai scope local pada Model
     *
     * @return array
     */
    public function totalVolumePerSatuan()
    {
        return  [

            'dokel' =>  RekapDokelKh::countVolume($this->year, $this->month, $this->wilker_id)
                        ->get(),

            'domas' =>  RekapDomasKh::countVolume($this->year, $this->month, $this->wilker_id)
                        ->get(),

            'ekspor' =>  RekapEksporKh::countVolume($this->year, $this->month, $this->wilker_id)
                        ->get(),

            'impor' =>  RekapImporKh::countVolume($this->year, $this->month, $this->wilker_id)
                        ->get(),

        ];
    }

    /**
     * Mengatur total rekapitulasi frekuensi, volume, pnbp berdasakan komoditi |
     * memakai scope local pada Model
     *
     * @return this
     */
    public function totalRekapitulasi()
    {
        $this->dokelTotalVolume  =  static::castNumberFormat(RekapDokelKh::countRekapitulasi(
                                        $this->year, $this->month, $this->wilker_id
                                    )->get());

        $this->domasTotalVolume  =  static::castNumberFormat(RekapDomasKh::countRekapitulasi(
                                        $this->year, $this->month, $this->wilker_id
                                    )->get());

        $this->eksporTotalVolume =  static::castNumberFormat(RekapEksporKh::countRekapitulasi(
                                        $this->year, $this->month, $this->wilker_id
                                    )->get());

        $this->imporTotalVolume  =  static::castNumberFormat(RekapImporKh::countRekapitulasi(
                                        $this->year, $this->month, $this->wilker_id
                                    )->get());
        return $this; 
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
     * Mengatur Total PNBP semua kegiatan |
     * memakai local scope pada model
     *
     * @return void
     */
    public function totalPnbp()
    {
        $this->pnbpDomas     =  RekapDomasKh::countTotalPnbp(
                                    $this->year, $this->month, $this->wilker_id
                                )->pnbp;

        $this->pnbpDokel     =  RekapDokelKh::countTotalPnbp(
                                    $this->year, $this->month, $this->wilker_id
                                )->pnbp;

        $this->pnbpEkspor    =  RekapEksporKh::countTotalPnbp(
                                    $this->year, $this->month, $this->wilker_id
                                )->pnbp;

        $this->pnbpImpor     =  RekapImporKh::countTotalPnbp(
                                    $this->year, $this->month, $this->wilker_id
                                )->pnbp;

        return $this;
    }

    /**
     * Mengatur Total Total Pemakaian Dokumen semua kegiatan |
     * memakai local scope pada model
     *
     * @return void
     */
    public function pemakaianDokumen()
    {
        return  DokumenKh::countPemakaianDokumen(
                    $this->year, $this->month, $this->wilker_id
                )->get();
    }

    /**
     * Mengatur Total Pembatalan Dokumen semua kegiatan |
     * memakai local scope pada model
     *
     * @return void
     */
    public function pembatalanDokumen()
    {
        return  PembatalanDokKh::countPembatalanDokumen(
                    $this->year, $this->month, $this->wilker_id
                )->get();
    }

    /**
     * Mengatur Total Frekuensi Per Bulan
     * memakai local scope pada model
     *
     * @return void
     */
    public function frekuensiKomoditiPerMonthKh()
    {
        $this->frekuensiKomoditiDokel    =   RekapDokelKh::countFrekuensiKomoditi(
                                                $this->year, $this->month, $this->wilker_id
                                             )->get();

        $this->frekuensiKomoditiDomas    =   RekapDomasKh::countFrekuensiKomoditi(
                                                $this->year, $this->month, $this->wilker_id
                                             )->get();

        $this->frekuensiKomoditiEkspor   =   RekapEksporKh::countFrekuensiKomoditi(
                                                $this->year, $this->month, $this->wilker_id
                                             )->get();

        $this->frekuensiKomoditiImpor    =   RekapImporKh::countFrekuensiKomoditi(
                                                $this->year, $this->month, $this->wilker_id
                                             )->get();
        return $this;
    }

    /**
     * Mengatur Top Five Komoditi Berdasarkan Frekuensi
     * memakai local scope pada model
     *
     * @return void
     */
    public function topFiveFrekuensiKomoditiKh()
    {
        return  [

            'dokel' =>  RekapDokelKh::topFiveFrekuensiKomoditi($this->year, $this->month, $this->wilker_id)
                        ->get(),

            'domas' =>  RekapDomasKh::topFiveFrekuensiKomoditi($this->year, $this->month, $this->wilker_id)
                        ->get(),

            'ekspor' =>  RekapEksporKh::topFiveFrekuensiKomoditi($this->year, $this->month, $this->wilker_id)
                        ->get(),

            'impor' =>  RekapImporKh::topFiveFrekuensiKomoditi($this->year, $this->month, $this->wilker_id)
                        ->get(),

        ];
    }

    /**
     * Mencari kota asal dan tujuan berdasarkan nama jenis MP, tahun, bulan dan wilker
     *
     * @param Request $request
     * @return collections
     */
    public function getDetailKota(Request $request)
    {
        $class      = $request->route()->parameter('class');
        $model      = $this->modelNamespace . $class;

        return $model::getDetailKotaByKomoditi($request);
    }

    /**
     * Untuk API Log Pengiriman Laporan
     * DIgunakan Oleh class HomeKhController
     * menggunakan local scope pada Model Loginfo
     *
     * @param int $year, int $wilker_id
     * @return Collection of Datatables
     */
    public function log($year, $month, $wilker, $type)
    {
        $log = LogInfo::karantinaHewanType($year, $month, $wilker, $type)->get();

        return app('DataTables')::of($log)->addIndexColumn()
         ->addColumn('action', function ($data) {

            if (empty($data->rolledback_at) || $data->rolledback_at == "") {

                if (\Carbon::now() > \Carbon::parse($data->created_at)->addWeek()) {

                    $action = '-';
                    
                } else {

                    $action = '<a href="#" data-id = "'.$data->id.'" class="btn btn-danger" id="rollbackOperasionalBtn">
                            <i class="fa fa-repeat fa-fw"></i> Rollback
                        </a>';
                }       

            } else {

               $action = '-';

            }

            return $action;

        })->make(true);
    }

    /**
     * Rollback action laporan operasional |
     * Paggil Rollback Event
     *
     * @param $request
     * @return void
     */
    public function rollback($request)
    {
        $log = LogInfo::find($request->id);

        event( new OperasionalRollbackEvent($log) );

        $log->update([

            "status" => 1,
            "rolledback_at" => \Carbon::now()

        ]);
    }
}