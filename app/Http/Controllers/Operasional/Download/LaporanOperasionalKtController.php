<?php 

namespace App\Http\Controllers\Operasional\Download;

use Illuminate\Http\Request;
use App\Models\MasterPegawai;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\TanggalController as Tanggal;

class LaporanOperasionalKtController extends DownloadController
{
	public function __construct(Request $request)
	{
		parent::__construct($request);
	}

	public function laporanOperasionalKt()
    {
    	
        return Excel::create("Laporan Operasional {$this->monthName} Tahun {$this->year} {$this->karantina}", function($excel) {

            foreach ($this->type as $permohonan) :

                $this->model = $this->modelNamespace . $permohonan . strtolower($this->karantina);

                $permohonanFullName = strtolower($permohonan); 
                
                $excel->sheet($permohonan, function($sheet) use ($permohonanFullName) {

                    $sheet->loadView('intern.operasional.kt.download.laporan_operasional')
                          ->with('headers', $this->tableTitleLaporanOperasionalKt())
                          ->with('bodies', $this->model::laporanOperasional($this->year, $this->month, $this->wilker_id))
                          ->with('permohonan', $this->getPermohonanFullName($permohonanFullName))
                          ->with('bulan', $this->month == 'all' ? '' : Tanggal::bulan($this->month))
                          ->with('tahun', $this->year)
                          ->with('signatory', MasterPegawai::with('jabatan')->find($this->signatory));

                    $this->sheetFormatting($sheet);

                    $sheet->setFontFamily('Arial');

                });

                $excel->getDefaultStyle()
                      ->getAlignment()
                      ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            endforeach;

        })->download('xls');
    }

    public function sheetFormatting($sheet)
    {
        $sheet->mergeCells('A1:AK1')->cells('A1:AK1', function($cells) {

        	$cells->setFontSize(12);
        	$cells->setFontWeight('bold');
           	
        })->mergeCells('A2:AK2')->cells('A2:AK2', function($cells) {

           	$cells->setFontSize(12);
           	$cells->setFontWeight('bold');
           
        })->mergeCells('A3:AK3')->cells('A3:AK3', function($cells) {

           	$cells->setFontSize(12);
           	$cells->setFontWeight('bold');
           
        })->mergeCells('A4:AK4')->cells('A4:AK4', function($cells) {

           	$cells->setFontSize(12);
           	$cells->setFontWeight('bold');
           
        });

		// Font size
		$sheet->setFontSize(9);

		// Set black background
		$sheet->cells('A6:AK6', function($cells) {

           	$cells->setFontSize(11);
           	$cells->setFontWeight('bold');
           
        });

        return $sheet;
    }
}