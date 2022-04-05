<?php 

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional\Download;

use Excel;
use Illuminate\Http\Request;
use App\Exports\Operasional\LaporanPemakaianDokumenKtExport;
use App\Repositories\Operasional\DataOperasionalKtRepository as Repository;

ini_set('max_execution_time', '500');

class LaporanPemakaianDokumenKtController extends DownloadController
{
    protected $year, $month, $wilker_id, $params, $request, $signatory, $karantina;

    public function __construct(Request $request)
    {

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
        return Excel::download(new LaporanPemakaianDokumenKtExport($this->request, $this->params), 'laporan_pemakaian_dokumen_kt.xlsx');
    }

}