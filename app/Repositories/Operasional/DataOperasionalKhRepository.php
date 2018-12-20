<?php 

namespace App\Repositories\Operasional;

use App\Traits\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Operasional\DokelKh;
use App\Models\Operasional\DomasKh;
use App\Models\Operasional\ImporKh;
use App\Models\Operasional\LogInfo;
use App\Models\Operasional\EksporKh;
use App\Contracts\RepositoryInterface;
use App\Events\OperasionalRollbackEvent;
use App\Http\Controllers\RupiahController as Rupiah;

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
     * Untuk menyimpan data pemakaian dokumen kegiatan domas
     *
     * @var collection
     */
    public $dokumenDomas;

    /**
     * Untuk menyimpan data pemakaian dokumen kegiatan dokel
     *
     * @var collection
     */
    public $dokumenDokel;

    /**
     * Untuk menyimpan data pemakaian dokumen kegiatan ekspor
     *
     * @var collection
     */
    public $dokumenEkspor;

    /**
     * Untuk menyimpan data pemakaian dokumen kegiatan impor
     *
     * @var collection
     */
    public $dokumenImpor;

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
    public $params;

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
        $this->year      = $year ?? date('Y');

        $this->month     = $month;

        $this->wilker_id = $wilker_id;

        $this->params    = [$this->year, $this->month, $this->wilker_id];
    }

    /**
     * Mengatur total frekuensi berdasakan jenis Kegiatan |
     * memakai scope local pada Model
     *
     * @return array
     */
    public function totalFrekuensiPerKegiatan()
    {
        $this->frekuensiDomas   = DomasKh::countFrekuensi($this->year, $this->month, $this->wilker_id);

        $this->frekuensiDokel   = DokelKh::countFrekuensi($this->year, $this->month, $this->wilker_id);

        $this->frekuensiEkspor  = EksporKh::countFrekuensi($this->year, $this->month, $this->wilker_id);

        $this->frekuensiImpor   = ImporKh::countFrekuensi($this->year, $this->month, $this->wilker_id);

        return $this;
    }

    /**
     * Mengatur total Volume berdasakan jenis Kegiatan |
     * memakai scope local pada Model
     *
     * @return this
     */
    public function totalRekapitulasi()
    {
        $this->dokelTotalVolume  = DokelKh::countRekapitulasi($this->year, $this->month, $this->wilker_id)->get();

        $this->domasTotalVolume  = DomasKh::countRekapitulasi($this->year, $this->month, $this->wilker_id)->get();

        $this->eksporTotalVolume = EksporKh::countRekapitulasi($this->year, $this->month, $this->wilker_id)->get();

        $this->imporTotalVolume  = ImporKh::countRekapitulasi($this->year, $this->month, $this->wilker_id)->get();

        return $this; 
    }

    public static function castPnbpToRupiah($collections)
    {
        return static::$collections->map(function($value, $key){
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
        $this->pnbpDomas     = DomasKh::countTotalPnbp($this->year, $this->month)->first()->pnbp;

        $this->pnbpDokel     = DokelKh::countTotalPnbp($this->year, $this->month)->first()->pnbp;

        $this->pnbpEkspor    = EksporKh::countTotalPnbp($this->year, $this->month)->first()->pnbp;

        $this->pnbpImpor     = ImporKh::countTotalPnbp($this->year, $this->month)->first()->pnbp;

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
        $this->dokumenDomas     = DomasKh::countPemakaianDokumen($this->year, $this->month)->get();

        $this->dokumenDokel     = DokelKh::countPemakaianDokumen($this->year, $this->month)->get();

        $this->dokumenEkspor    = EksporKh::countPemakaianDokumen($this->year, $this->month)->get();

        $this->dokumenImpor     = ImporKh::countPemakaianDokumen($this->year, $this->month)->get();

        return $this;
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
        $mp         = $request->route()->parameter('mp');
        $year       = $request->route()->parameter('year');
        $month      = $request->route()->parameter('month');
        $wilker_id  = $request->route()->parameter('wilker_id');
        $model      = $this->modelNamespace . $class;

        $getDetailKota  = $model::select(
                            'kota_tuju', 
                            'kota_asal', 
                            'dok_pelepasan',
                            DB::raw('count(*) as total'),
                            DB::raw('count(dok_pelepasan) as pemakaian_dokumen')
                          )
                          ->where('kota_tuju', '!=', null)
                          ->where('nama_mp', [$mp]);

        if ($wilker_id !== null) {

            $getDetailKota->where('wilker_id', $wilker_id);
        } 

        if ($month !== null) {

            $getDetailKota->whereMonth('bulan', $month);
        }

        if ($year === null) {

            $getDetailKota->whereYear('bulan', date('Y'));
           
        } else {

            $getDetailKota->whereYear('bulan', $year);
        }

        return $getDetailKota->groupBy('kota_tuju')->get();
    }


    /**
     * Untuk API Log Pengiriman Laporan
     * DIgunakan Oleh class HomeKhController
     * menggunakan local scope pada Model Loginfo
     *
     * @param int $year, int $wilker_id
     * @return Collection of Datatables
     */
    public function log($year, $wilker)
    {
        $log = LogInfo::karantinaHewanType($year, $wilker)->get();

        return app('DataTables')::of($log)->addIndexColumn()
         ->addColumn('action', function ($data) {

            if (empty($data->rolledback_at) || $data->rolledback_at == "") {

                if (\Carbon::now()->subDays(7)->format('d-m-Y') > $data->created_at) {

                    $action = '-';
                    
                }else{

                    $action = '<a href="#" data-id = "'.$data->id.'" class="btn btn-danger" id="rollbackOperasionalBtn">
                            <i class="fa fa-repeat fa-fw"></i> Rollback
                        </a>';
                }       

            }else{

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