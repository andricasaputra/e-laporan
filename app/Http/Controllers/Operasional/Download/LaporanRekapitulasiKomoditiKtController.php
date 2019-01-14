<?php 

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional\Download;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\Operasional\DataOperasionalKtRepository as Repository;

ini_set('max_execution_time', '200');

class LaporanRekapitulasiKomoditiKtController extends DownloadController
{
    /**
     * Menyimpan start row untuk isi data laporan pada table
     *
     * @var int
     */
    public $startDataRow = 7;

    /**
     * Populasi property yang dibutuhkan
     *
     * @return void
     */
  	public function __construct(Repository $repository, Request $request)
  	{
  		parent::__construct($request);

        $this->repository = new $repository($this->year, $this->month, $this->wilker_id);
  	}

    /**
     * Method utama yang dipanggil untuk export
     *
     * @return Excel
     */
	public function laporanRekapitulasiKomoditiKt()
    {
        return Excel::create("Laporan Rekapitulasi Komoditi KT {$this->monthName} Tahun {$this->year} {$this->karantina} {$this->wilkerName}", function($excel) {

            /*Looping sesuai banyak tipe permohonan yang dipilih*/
            foreach ($this->type as $permohonan) :

                /*model yang dipakai sesuai permohonan (domas, dokel, ekspor, impor, reekspor, serahterima)*/
                $this->model = $this->modelNamespace . $permohonan . ucfirst(strtolower($this->karantina));
                
                $excel->sheet($permohonan, function($sheet) use ($permohonan) {

                    /*init page view/ source page laporan*/
                    $sheet->loadView('intern.operasional.kt.download.laporan_operasional_excel')
                          ->with('datas', $this->datasToView(strtolower($permohonan)));
                  
                    /*jika data null atau nihil*/
                    if (count($this->datasToView(strtolower($permohonan))['bodies']) === 0) {

                      $this->nullSheetFormatting($sheet);

                    /*jika data tidak nihil*/
                    } else {

                      $this->sheetFormatting($sheet);

                    }

                    /*set global orientation laporan*/
                    $sheet->setOrientation('potrait');

                    /*set paper size laporan =  A3*/
                    $sheet->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);

                    /*set rowheight hanya untuk data di dalam table*/
                    $this->setRowHeight($sheet, $permohonan);

                    /*set global font family*/
                    $sheet->setFontFamily('Arial');
                    
                });

            endforeach;

            /*global alignment laporan horizontal center*/
            $excel->getDefaultStyle()
                  ->getAlignment()
                  ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        })->download('xls');
    }

}