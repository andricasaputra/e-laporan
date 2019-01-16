<?php

namespace App\Http\Controllers\Operasional\Download;

use App\Models\Wilker;
use Illuminate\Http\Request;
use App\Models\MasterPegawai;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\TableOperasionalProperty;
use App\Http\Controllers\TanggalController as Tanggal;

class DownloadController extends Controller
{
    use TableOperasionalProperty;

    /**
     * Menyimpan Instance repository yang dipakai
     *
     * @var App\Repositories\Operasional\DataOperasionalKhRepository
     */
    protected $repository;

    /**
    * Untuk Menyimpan tahun laporan
    *
    * @var int
    */
    protected $year;

    /**
    * Untuk Menyimpan bulan laporan
    *
    * @var string
    */
    protected $month;

    /**
    * Untuk Menyimpan wilker laporan
    *
    * @var string
    */
    protected $wilker_id;

    /**
    * Untuk Menyimpan nama wilker laporan
    *
    * @var string
    */
    protected $wilkerName;

    /**
    * Untuk Menyimpan jenis permohonan laporan
    *
    * @var string
    */
    protected $type;

    /**
    * Untuk Menyimpan jenis karantina laporan
    *
    * @var string
    */
    protected $karantina;

    /**
    * Untuk Menyimpan id penandatangan laporan
    *
    * @var int
    */
    protected $signatory;

    /**
    * Untuk Menyimpan pilihan semua jenis permohonan laporan
    *
    * @var array
    */
    protected $all = ['Dokel', 'Domas', 'Ekspor', 'Impor', 'Reekspor' ,'SerahTerima'];

    /**
    * Untuk Menyimpan namespace model yang akan dipakai
    *
    * @var string
    */
    protected $modelNamespace = 'App\\Models\\Operasional\\';

    /**
    * Untuk Menyimpan nama class dari model
    *
    * @var string
    */
    protected $model;

    protected $paperSize;

    protected $scale;

    protected $orientation;

    protected $fontFamily;

    /**
    * Set semua property
    *
    * @param Request $request
    * @return void
    */
    protected function __construct(Request $request)
    {
    	  $this->year 	      = $request->year;
    	  $this->month 	      = $request->month;
        $this->monthName    = $this->getMonthName($this->month);
    	  $this->wilker_id    = $request->wilker_id;
        $this->wilkerName   = $this->getWilkerName($this->wilker_id);
    	  $this->type 	      = $this->getPermohonanType($request->type);
        $this->karantina    = strtoupper($request->karantina);
        $this->signatory    = $request->signatory;
        $this->paperSize    = $request->paperSize;
        $this->scale        = $request->scale;
        $this->orientation  = $request->orientation;
        $this->fontFamily   = $request->font;
    }

    /**
    * Untuk mendapatkan Fullname jenis laporan, 
    * Ex : Dokel => Domestik Keluar
    *
    * @param string $permohonan
    * @return string
    */
    protected function getPermohonanFullName($permohonan)
    {
        return $this->model::getPermohonanFullName($permohonan);
    }

    /**
     * Untuk mendapatkan tipe permohonan
     *
     * @param string $type
     * @return string|array
     */
    protected function getPermohonanType($type)
    {
        return $type == 'all' ? $this->all : [$type];
    }

    /**
     * Untuk mendapatkan pejabat penandatangan laporan
     *
     * @param string $signatory
     * @return array
     */
    protected function getSignatory($signatory)
    {
        return MasterPegawai::with('jabatan')->find($signatory);
    }

    /**
     * Untuk mendapatkan bulan
     *
     * @return string
     */
    protected function getMonth()
    {
        return $this->month == 'all' ? '' : Tanggal::bulan($this->month);
    }

    /**
     * Untuk mendapatkan nama bulan
     *
     * @param string $month
     * @return string
     */
    protected function getMonthName($month)
    {
        return $month == 'all' ? '' : 'Bulan ' . Tanggal::bulan($this->month);
    }

    /**
     * Untuk mendapatkan nama wilker
     *
     * @param string $wilker
     * @return string
     */
    protected function getWilkerName($wilker)
    {
        return  Wilker::find($wilker) === null 
                  ? 'UPT : '. Wilker::find(1)->nama_wilker
                  : Wilker::find($wilker)->nama_wilker;
    }

}
