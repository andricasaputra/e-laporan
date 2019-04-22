<?php 

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional\Download;

use Illuminate\Http\Request;
use App\Exports\Operasional\LaporanRekapitulasiKomoditiKhExport;
use App\Exports\Operasional\LaporanRekapitulasiKomoditiKtExport;
use App\Repositories\Operasional\DataOperasionalKhRepository as KhRepository;
use App\Repositories\Operasional\DataOperasionalKtRepository as KtRepository;

ini_set('max_execution_time', '500');

class LaporanRekpitulasiKomoditiController extends AbstractDownloadLaporanController
{
    /**
    * Set semua property yang diperlukan untuk class ini dan parent
    *
    * @param Illuminate\Http\Request $request
    * @return void
    */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * Untuk download excel dari laporan operasional karantina hewan
     *
     * @return void
     */
    public function laporanRekapitulasiKomoditiKh()
    {
        return (new LaporanRekapitulasiKomoditiKhExport($this->request))->download($this->getLaporanTitle() . '.xlsx');
    }

    /**
     * Untuk download excel dari laporan operasional karantina tumbuhan
     *
     * @return void
     */
    public function laporanRekapitulasiKomoditiKt()
    {
        return (new LaporanRekapitulasiKomoditiKtExport($this->request))->download($this->getLaporanTitle() . '.xlsx');
    }

    /**
     * Untuk set judul laporan yang akan di download
     *
     * @return string
     */
    public function setLaporanTitle() : string
    {
        return "Laporan Rekapitulasi Komoditi {$this->permohonan} {$this->karantina} {$this->monthName} Tahun {$this->year} {$this->wilkerName}";
    }

    /**
     * Untuk mendapatkan judul laporan yang akan di download
     *
     * @return string
     */
    public function getLaporanTitle() : string
    {
        return $this->setLaporanTitle();
    }

}