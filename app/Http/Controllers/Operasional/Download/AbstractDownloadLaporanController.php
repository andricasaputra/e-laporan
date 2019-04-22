<?php

namespace App\Http\Controllers\Operasional\Download;

use App\Models\Wilker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

abstract class AbstractDownloadLaporanController extends Controller
{
    /**
     * Menyimpan Instance dari request
     *
     * @var Illuminate\Http\Request $request
     */
    protected $request;

    /**
    * Untuk Menyimpan tahun laporan
    *
    * @var int
    */
    protected $year;

    /**
    * Untuk Menyimpan nama bulan laporan
    *
    * @var string
    */
    protected $monthName;

    /**
    * Untuk Menyimpan jenis karantina laporan
    *
    * @var string
    */
    protected $karantina;

    /**
    * Untuk Menyimpan nama wilker laporan
    *
    * @var string
    */
    protected $wilkerName;

    /**
    * Untuk Menyimpan jenis permohonan
    *
    * @var string
    */
    protected $permohonan;

    /**
    * Set semua property yang diperlukan untuk class ini dan turunan
    *
    * @param Illuminate\Http\Request $request
    * @return void
    */
    protected function __construct(Request $request)
    {
        $this->request    = $request;

        $this->year       = $request->year;

        $this->karantina  = strtoupper($request->karantina);

        $this->monthName  = $this->getMonthName($request->month);

        $this->wilkerName = $this->getWilkerName($request->wilker_id);
 
        $this->permohonan = $request->type == 'all' ? '' : $request->type;
    }

    /**
     * Untuk mendapatkan nama wilker
     *
     * @param string $wilker
     * @return string
     */
    protected function getWilkerName($wilker)
    {
        return (! isset($wilker)) ? Wilker::find(1)->nama_wilker : Wilker::find($wilker)->nama_wilker;
    }

    /**
     * Untuk mendapatkan nama bulan
     *
     * @param string $month
     * @return string
     */
    protected function getMonthName($month)
    {
        return $month == 'all' ? '' : 'Bulan ' . bulan($month);
    }

    abstract public function setLaporanTitle() : string;

    abstract public function getLaporanTitle() : string;
}
