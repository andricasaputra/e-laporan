<?php

namespace App\Exports\Operasional;

use App\Models\Operasional\Dokumen\PemakaianDokumenKh;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Traits\Operasional\TableOperasionalHeader;
use Illuminate\Support\Collection;
use App\Repositories\Operasional\DataOperasionalKhRepository as Repository;
use App\models\MasterPegawai;

class LaporanPemakaianDokumenKhExport implements FromView, ShouldAutoSize
{
    use TableOperasionalHeader;

    protected $params, $repository;

    public function __construct($request, array $params)
    {
        $this->params = $params;

        $this->repository = new Repository($request);

        $this->signatory   = $request->signatory;
    }

     /**
     * @return Builder
     */
    public function view() : View
    {
        return view('intern.operasional.kh.download.laporan_pemakaian_dokumen_excel')->withDatas($this->sentDatasToView());
    }

    /**
     * @return string
     */
    public function title() : string
    {
        return "Laporan Pemakaian Dokumen {$this->params['month']} Tahun {$this->params['year']} Karantina HEWAN Wilker {$this->params['wilkerId']}";
    }

    protected function getTableHeader() : array
    {
        return $this->tableHeaderLaporanRekapitulasiKomoditiKh();
    }

    public function sentDatasToView() : array
    {
        return [

            'bodies'     => $this->getData(),
            'bulan'      => $this->params['month'],
            'tahun'      => $this->params['year'],
            'wilker'     => $this->params['wilkerId'],
            'permohonan' => 'Semua',
            'headers'   => $this->getTableHeader(),
             'signatory'  => $this->getSignatory($this->signatory),

        ];
    }

     protected function getSignatory($signatory)
    {
        return MasterPegawai::with('jabatan')->find($signatory);
    }

    protected function setData()
    {
        /*set data penerimaan*/
        $this->penerimaanBulanIni   =   $this->repository->penerimaanDokumen()
                                             ->mapWithKeys(function ($item) {
                                                return [
                                                    str_replace('-', '', $item->dokumen->dokumen) => (int) $item['total']
                                                ];
                                            })->sortKeys();

        $this->penerimaanBulanLalu  =   $this->repository->penerimaanDokumenBulanLalu()
                                             ->mapWithKeys(function ($item) {
                                                return [
                                                   str_replace('-', '', $item->dokumen->dokumen) => (int) $item['total']
                                                ];
                                            })->sortKeys();

        $this->totalPenerimaan      =   $this->repository->totalPenerimaanDokumen()
                                             ->mapWithKeys(function ($item) {
                                                return [
                                                   str_replace('-', '', $item->dokumen->dokumen) => (int) $item['total']
                                                ];
                                            })->sortKeys();

        /*set data pemakaian*/
        $this->pemakaianBulanIni    =   $this->repository->pemakaianDokumen(true)
                                             ->mapWithKeys(function ($item) {
                                                return [$item['dokumen'] => (int) $item['total']];
                                            })->sortKeys();

        $this->pemakaianBulanLalu   =   $this->repository->pemakaianDokumenBulanLalu(true)
                                             ->mapWithKeys(function ($item) {
                                                return [$item['dokumen'] => (int) $item['total']];
                                            })->sortKeys();

        $this->totalPemakaian       =   $this->repository->totalPemakaianDokumen()
                                             ->mapWithKeys(function ($item) {
                                                return [$item['dokumen'] => (int) $item['total']];
                                            })->sortKeys();

        $this->totalPembatalan      =   $this->repository->pembatalanDokumen()
                                             ->mapWithKeys(function ($item) {
                                                 return [
                                                    $item['dokumen'] => [
                                                        'total' => $item->count(),
                                                        'no_seri' => $item->no_seri
                                                    ],
                                                ];
                                            })->sortKeys();
        return $this;
    }

    /**
     * Untuk set data utama pada body table laporan
     *
     * @return array
     */
    protected function getData()
    {
        /*get data*/
        return [

           'penerimaanbulanIni'  => $this->setData()->penerimaanBulanIni->all(),
           'penerimaanbulanLalu' => $this->setData()->penerimaanBulanLalu->all(),
           'penerimaantotal'     => $this->setData()->totalPenerimaan->all(),
           'pemakaianbulanIni'   => $this->setData()->pemakaianBulanIni->all(),
           'pemakaianbulanLalu'  => $this->setData()->pemakaianBulanLalu->all(),
           'pemakaiantotal'      => $this->setData()->totalPemakaian->all(),
           'pembatalantotal'     => $this->setData()->totalPembatalan->all(),

        ];
    }

   /* protected function getBodyData() : Collection
    {
        return PemakaianDokumenKh::getJumlahKhDokumen($this->params);
    }*/
/*
    public function collection()
    {
        return PemakaianDokumenKh::getJumlahKhDokumen($this->params);
    }*/
}