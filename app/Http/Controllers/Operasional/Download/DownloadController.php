<?php

namespace App\Http\Controllers\Operasional\Download;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\TableOperasionalProperty;
use App\Http\Controllers\TanggalController as Tanggal;

class DownloadController extends Controller
{
    use TableOperasionalProperty;

	  protected $year;

	  protected $month;

	  protected $wilker_id;

	  protected $type;

    protected $karantina;

    /**
    * Untuk Menyimpan id penandatangan laporan
    *
    * @var int
    */
    protected $signatory;

    protected $all = ['Dokel', 'Domas', 'Ekspor', 'Impor', 'SerahTerima'];

    protected $modelNamespace = 'App\\Models\\Operasional\\';

    protected $model;

    public function __construct(Request $request)
    {
    	  $this->year 	    = $request->year;
    	  $this->month 	    = $request->month;
        $this->monthName  = $this->month == 'all' ? '' : 'Bulan ' . Tanggal::bulan($this->month);
    	  $this->wilker_id 	= $request->wilker_id;
    	  $this->type 	    = $request->type == 'all' ? $this->all : [$request->type];
        $this->karantina  = strtoupper($request->karantina);
        $this->signatory  = $request->signatory;
    }

    protected function getPermohonanFullName($permohonan)
    {
        return $this->model::getPermohonanFullName($permohonan);
    }

}
