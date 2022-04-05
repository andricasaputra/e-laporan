<?php 

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional\Download;

use Excel;
use Illuminate\Http\Request;
use App\Exports\Operasional\LaporanPemakaianDokumenKhExport;
use App\Repositories\Operasional\DataOperasionalKtRepository as Repository;

ini_set('max_execution_time', '500');

class LaporanPemakaianDokumenKhController extends DownloadController
{
    protected $year, $month, $wilker_id, $params, $request, $signatory, $karantina;

    public function __construct(Request $request)
    {

        /*  "_method" => "POST"
          "jenisLaporan" => "laporan_pemakaian_dokumen"
          "year" => "2022"
          "month" => "all"
          "wilker_id" => "2"
          "signatory" => "100"
          "karantina" => "Kh"
          "paperSize" => "9"
          "scale" => "100"
          "orientation" => "landscape"
          "font" => "Arial"
        ]*/

        $this->year = $request->year;

        $this->month = $request->month;

        $this->wilker_id = $request->wilker_id;

        $this->request = $request;

        $this->signatory = $request->signatory;

        $this->karantina = $request->karantina;

        $this->params = [
            'year' => $this->year, 
            'month' => $this->month, 
            'wilkerId' => $this->wilker_id
        ];
    }

    public function export()
    {
        return Excel::download(new LaporanPemakaianDokumenKhExport($this->request, $this->params), 'laporan_pemakaian_dokumen_kh.xlsx');
    }

}