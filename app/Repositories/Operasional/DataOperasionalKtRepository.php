<?php 

namespace App\Repositories\Operasional;

use App\Models\Operasional\LogInfo;
use App\Models\Operasional\Dokumen\PembatalanDokKt;
use App\Models\Operasional\Dokumen\PemakaianDokumenKt as DokumenKt;
use App\Models\Operasional\Dokumen\PenerimaanDokumenKt as Penerimaan;
use App\Models\Operasional\RekapitulasiKomoditiDokelKt as RekapDokelKt;
use App\Models\Operasional\RekapitulasiKomoditiDomasKt as RekapDomasKt;
use App\Models\Operasional\RekapitulasiKomoditiImporKt as RekapImporKt;
use App\Models\Operasional\RekapitulasiKomoditiEksporKt as RekapEksporKt;
use App\Models\Operasional\RekapitulasiKomoditiReeksporKt as RekapReeksporKt;
use App\Models\Operasional\RekapitulasiKomoditiSerahTerimaKt as RekapSerahTerimaKt;

class DataOperasionalKtRepository extends DataOperasionalRepositoryManager
{
    /**
     * Mengatur total frekuensi berdasakan jenis Kegiatan |
     * memakai scope local pada Model
     *
     * @return array
     */
    public function totalFrekuensiPerKegiatan()
    {
        $this->frekuensiDomas       =   RekapDomasKt::countFrekuensi(
                                            $this->year, $this->month, $this->wilker_id
                                        )->frekuensi;

        $this->frekuensiDokel       =   RekapDokelKt::countFrekuensi(
                                            $this->year, $this->month, $this->wilker_id
                                        )->frekuensi;

        $this->frekuensiEkspor      =   RekapEksporKt::countFrekuensi(
                                            $this->year, $this->month, $this->wilker_id
                                        )->frekuensi;

        $this->frekuensiImpor       =   RekapImporKt::countFrekuensi(
                                            $this->year, $this->month, $this->wilker_id
                                        )->frekuensi;

        $this->frekuensiReekspor    =   RekapReeksporKt::countFrekuensi(
                                            $this->year, $this->month, $this->wilker_id
                                        )->frekuensi;

        $this->frekuensiSerahTerima =   RekapSerahTerimaKt::countFrekuensi(
                                            $this->year, $this->month, $this->wilker_id
                                        )->frekuensi;

        return $this;
    }

    /**
     * Mengatur total volume komoditi per satuan |
     * memakai scope local pada Model
     *
     * @return array
     */
    public function totalVolumePerSatuan()
    {
        return  [

            'dokel'         =>  RekapDokelKt::countVolume(
                                    $this->year, $this->month, $this->wilker_id
                                )->get(),

            'domas'         =>  RekapDomasKt::countVolume(
                                    $this->year, $this->month, $this->wilker_id
                                )->get(),

            'ekspor'        =>  RekapEksporKt::countVolume(
                                    $this->year, $this->month, $this->wilker_id
                                )->get(),

            'impor'         =>  RekapImporKt::countVolume(
                                    $this->year, $this->month, $this->wilker_id
                                )->get(),

            'reekspor'      =>  RekapReeksporKt::countVolume(
                                    $this->year, $this->month, $this->wilker_id
                                )->get(),

            'serahterima'   =>  RekapSerahTerimaKt::countVolume(
                                    $this->year, $this->month, $this->wilker_id
                                )->get(),

        ];
    }

    /**
     * Mengatur total rekapitulasi frekuensi, volume, pnbp berdasakan komoditi |
     * memakai scope local pada Model
     *
     * @return this
     */
    public function totalRekapitulasi()
    {
        $this->dokelTotalVolume         =  parent::castNumberFormat(RekapDokelKt::countRekapitulasi(
                                                $this->year, $this->month, $this->wilker_id
                                            )->get());

        $this->domasTotalVolume         =  parent::castNumberFormat(RekapDomasKt::countRekapitulasi(
                                                $this->year, $this->month, $this->wilker_id
                                            )->get());

        $this->eksporTotalVolume        =  parent::castNumberFormat(RekapEksporKt::countRekapitulasi(
                                                $this->year, $this->month, $this->wilker_id
                                            )->get());

        $this->imporTotalVolume          =  parent::castNumberFormat(RekapImporKt::countRekapitulasi(
                                                $this->year, $this->month, $this->wilker_id
                                            )->get());

        $this->reeksporTotalVolume      =  parent::castNumberFormat(RekapReeksporKt::countRekapitulasi(
                                                $this->year, $this->month, $this->wilker_id
                                            )->get());

        $this->serahTerimaTotalVolume   =  parent::castNumberFormat(RekapSerahTerimaKt::countRekapitulasi(
                                                $this->year, $this->month, $this->wilker_id
                                            )->get());

        return $this; 
    }


    /**
     * Mengatur Total PNBP semua kegiatan |
     * memakai local scope pada model
     *
     * @return void
     */
    public function totalPnbp()
    {
        $this->pnbpDomas        =   RekapDomasKt::countTotalPnbp(
                                        $this->year, $this->month, $this->wilker_id
                                    )->pnbp;

        $this->pnbpDokel        =   RekapDokelKt::countTotalPnbp(
                                        $this->year, $this->month, $this->wilker_id
                                    )->pnbp;

        $this->pnbpEkspor       =   RekapEksporKt::countTotalPnbp(
                                        $this->year, $this->month, $this->wilker_id
                                    )->pnbp;

        $this->pnbpImpor        =   RekapImporKt::countTotalPnbp(
                                        $this->year, $this->month, $this->wilker_id
                                    )->pnbp;

        $this->pnbpReekspor     =   RekapReeksporKt::countTotalPnbp(
                                        $this->year, $this->month, $this->wilker_id
                                    )->pnbp;

        $this->pnbpSerahTerima  =   RekapSerahTerimaKt::countTotalPnbp(
                                        $this->year, $this->month, $this->wilker_id
                                    )->pnbp;

        return $this;
    }

    /**
     * Mengatur Total Frekuensi Per Bulan
     * memakai local scope pada model
     *
     * @return void
     */
    public function frekuensiKomoditiPerMonthKt()
    {
        $this->frekuensiKomoditiDokel           =   RekapDokelKt::countFrekuensiKomoditi(
                                                        $this->year, $this->month, $this->wilker_id
                                                    )->get();

        $this->frekuensiKomoditiDomas           =   RekapDomasKt::countFrekuensiKomoditi(
                                                        $this->year, $this->month, $this->wilker_id
                                                    )->get();

        $this->frekuensiKomoditiEkspor          =   RekapEksporKt::countFrekuensiKomoditi(
                                                        $this->year, $this->month, $this->wilker_id
                                                    )->get();

        $this->frekuensiKomoditiImpor           =   RekapImporKt::countFrekuensiKomoditi(
                                                        $this->year, $this->month, $this->wilker_id
                                                    )->get();

        $this->frekuensiKomoditiReekspor        =   RekapReeksporKt::countFrekuensiKomoditi(
                                                        $this->year, $this->month, $this->wilker_id
                                                    )->get();

        $this->frekuensiKomoditiSerahTerima     =   RekapSerahTerimaKt::countFrekuensiKomoditi(
                                                        $this->year, $this->month, $this->wilker_id
                                                    )->get();

        return $this;
    }

    /**
     * Mengatur Top Five Komoditi Berdasarkan Frekuensi
     * memakai local scope pada model
     *
     * @return void
     */
    public function topFiveFrekuensiKomoditiKt()
    {
        return  [

            'dokel'         =>  RekapDokelKt::topFiveFrekuensiKomoditi(
                                    $this->year, $this->month, $this->wilker_id
                                )->get(),

            'domas'         =>  RekapDomasKt::topFiveFrekuensiKomoditi(
                                    $this->year, $this->month, $this->wilker_id
                                )->get(),

            'ekspor'        =>  RekapEksporKt::topFiveFrekuensiKomoditi(
                                    $this->year, $this->month, $this->wilker_id
                                )->get(),

            'impor'         =>  RekapImporKt::topFiveFrekuensiKomoditi(
                                    $this->year, $this->month, $this->wilker_id
                                )->get(),

            'reekspor'      =>  RekapReeksporKt::topFiveFrekuensiKomoditi(
                                    $this->year, $this->month, $this->wilker_id
                                )->get(),

            'serahterima'   =>  RekapSerahTerimaKt::topFiveFrekuensiKomoditi(
                                    $this->year, $this->month, $this->wilker_id
                                )->get(),

        ];
    }

    /**
     * Mengatur Total Penerimaan Dokumen semua kegiatan |
     * memakai local scope pada model
     *
     * @return void
     */
    public function penerimaanDokumen($excel = false)
    {
        return  Penerimaan::countPenerimaanDokumen(
                  $this->year, $this->month, $this->wilker_id, $excel
                );
    }

    /**
     * Mengatur Total Penerimaan Dokumen bulan sebelumnya, untuk tanggal tertentu |
     * memakai local scope pada model
     *
     * @param bool $excel -> untuk pemakaian pada laporan excel, default false = tidak untuk excel
     * @return array
     */
    public function penerimaanDokumenBulanLalu($excel = true)
    {
        return  Penerimaan::countPenerimaanDokumen(
                    $this->bulanLalu()['year'], $this->bulanLalu()['lastMonth'], $this->wilker_id, $excel
                );
    }

    /**
     * Mengatur Total Pemakaian Dokumen semua kegiatan |
     * memakai local scope pada model
     *
     * @return array
     */
    public function totalPenerimaanDokumen()
    {
        return  Penerimaan::countTotalPemakaianDokumen(
                    $this->year, $this->month, $this->wilker_id
                );
    }

    /**
     * Mengatur Total Pemakaian Dokumen semua kegiatan untuk tanggal tertentu |
     * memakai local scope pada model
     *
     * @param bool $excel -> untuk pemakaian pada laporan excel, default false = tidak untuk excel
     * @return array
     */
    public function pemakaianDokumen($excel = false)
    {
        return  DokumenKt::countPemakaianDokumen(
                    $this->year, $this->month, $this->wilker_id, $excel
                )->get();
    }

    /**
     * Mengatur Total Pemakaian Dokumen bulan sebelumnya, untuk tanggal tertentu |
     * memakai local scope pada model
     *
     * @param bool $excel -> untuk pemakaian pada laporan excel, default false = tidak untuk excel
     * @return array
     */
    public function pemakaianDokumenBulanLalu($excel = false)
    {
        return  DokumenKt::countPemakaianDokumen(
                    $this->bulanLalu()['year'], $this->bulanLalu()['lastMonth'], $this->wilker_id, $excel
                )->get();
    }

    /**
     * Mengatur Total Pemakaian Dokumen semua kegiatan |
     * memakai local scope pada model
     *
     * @return array
     */
    public function totalPemakaianDokumen()
    {
        return  DokumenKt::countTotalPemakaianDokumen(
                    $this->year, $this->month, $this->wilker_id
                )->get();
    }

    /**
     * Mengatur Total Pembatalan Dokumen semua kegiatan |
     * memakai local scope pada model
     *
     * @return void
     */
    public function pembatalanDokumen()
    {
        return  PembatalanDokKt::getJumlahKtDokumen(
                    ['year' => $this->year, 'month' => $this->month, 'wilkerId' => $this->wilker_id]
                );
    }


    private function bulanLalu()
    {
        if ($this->month == 'all') {

            $lastMonth = \Carbon::parse($this->year)->subMonth()->month;

            $year  = \Carbon::parse($this->year)->subYear()->year;

        } else {

            $lastMonth = \Carbon::parse($this->year .'-'. $this->month)->subMonth()->month;

            if ($this->month == 1) {

                $year  = \Carbon::parse($this->year .'-'. $this->month)->subYear()->year;

            } else {

                $year  = $this->year;

            }

        }

        return [

            'lastMonth' => $lastMonth,
            'year' => $year
        ];
    }

    /**
     * Untuk API Log Pengiriman Laporan
     * DIgunakan Oleh class HomeKtController
     * menggunakan local scope pada Model Loginfo
     *
     * @param int $year, int $wilker_id
     * @return Collection of Datatables
     */
    public function log($year, $month, $wilker, $type)
    {
        $log = LogInfo::karantinaTumbuhanType($year, $month, $wilker, $type)->get();
        
        return datatables($log)->addIndexColumn()
         ->addColumn('action', function ($datas) {

            /*
            * Hilangkan tombol rollback jika :
            * 1. laporan sudah pernah di rollback sebelumnya,
            * 2. laporan telah diupload lebih dari seminggu yang lalu,
            *    karena jika sudah lebih dari seminggu, laporan kita asumsikan valid
            *    dan tidak dapat di rollback kembali
            */
            return $datas->when(is_null($datas->rolledback_at) && (int) $datas->status == 1 , function($i) use ($datas){

                return  now() > \Carbon::parse($datas->created_at)->addWeek() 
                        ? '-'
                        :'<a href="#" data-id = "'.$datas->id.'" class="btn btn-danger" id="rollbackOperasionalBtn">
                            <i class="fa fa-repeat fa-fw"></i> Rollback
                         </a>';

            }, function($i) {

                return '-';

            });

        })->make(true);
    }
    
}