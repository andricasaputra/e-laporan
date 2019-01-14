<?php 

namespace App\Repositories\Operasional;

use App\Models\Operasional\LogInfo;
use App\Models\Operasional\PembatalanDokKh;
use App\Models\Operasional\PemakaianDokumenKh as DokumenKh;
use App\Models\Operasional\RekapitulasiKomoditiDokelKh as RekapDokelKh;
use App\Models\Operasional\RekapitulasiKomoditiDomasKh as RekapDomasKh;
use App\Models\Operasional\RekapitulasiKomoditiImporKh as RekapImporKh;
use App\Models\Operasional\RekapitulasiKomoditiEksporKh as RekapEksporKh;
use App\Models\Operasional\RekapitulasiKomoditiReeksporKh as RekapReeksporKh;
use App\Models\Operasional\RekapitulasiKomoditiSerahTerimaKh as RekapSerahTerimaKh;

class DataOperasionalKhRepository extends DataOperasionalRepositoryManager
{
    /**
     * Mengatur total frekuensi berdasakan jenis Kegiatan |
     * memakai scope local pada Model
     *
     * @return array
     */
    public function totalFrekuensiPerKegiatan()
    {
        $this->frekuensiDomas       =   RekapDomasKh::countFrekuensi(
                                            $this->year, $this->month, $this->wilker_id
                                        )->frekuensi;

        $this->frekuensiDokel       =   RekapDokelKh::countFrekuensi(
                                            $this->year, $this->month, $this->wilker_id
                                        )->frekuensi;

        $this->frekuensiEkspor      =   RekapEksporKh::countFrekuensi(
                                            $this->year, $this->month, $this->wilker_id
                                        )->frekuensi;

        $this->frekuensiImpor       =   RekapImporKh::countFrekuensi(
                                            $this->year, $this->month, $this->wilker_id
                                        )->frekuensi;

        $this->frekuensiReekspor    =   RekapReeksporKh::countFrekuensi(
                                            $this->year, $this->month, $this->wilker_id
                                        )->frekuensi;

        $this->frekuensiSerahTerima =   RekapSerahTerimaKh::countFrekuensi(
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

            'dokel'         =>  RekapDokelKh::countVolume(
                                    $this->year, $this->month, $this->wilker_id
                                )->get(),

            'domas'         =>  RekapDomasKh::countVolume(
                                    $this->year, $this->month, $this->wilker_id
                                )->get(),

            'ekspor'        =>  RekapEksporKh::countVolume(
                                    $this->year, $this->month, $this->wilker_id
                                )->get(),

            'impor'         =>  RekapImporKh::countVolume(
                                    $this->year, $this->month, $this->wilker_id
                                )->get(),

            'reekspor'      =>  RekapReeksporKh::countVolume(
                                    $this->year, $this->month, $this->wilker_id
                                )->get(),

            'serahterima'   =>  RekapSerahTerimaKh::countVolume(
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
        $this->dokelTotalVolume         =  parent::castNumberFormat(RekapDokelKh::countRekapitulasi(
                                                $this->year, $this->month, $this->wilker_id
                                            )->get());

        $this->domasTotalVolume         =  parent::castNumberFormat(RekapDomasKh::countRekapitulasi(
                                                $this->year, $this->month, $this->wilker_id
                                            )->get());

        $this->eksporTotalVolume        =  parent::castNumberFormat(RekapEksporKh::countRekapitulasi(
                                                $this->year, $this->month, $this->wilker_id
                                            )->get());

        $this->imporTotalVolume          =  parent::castNumberFormat(RekapImporKh::countRekapitulasi(
                                                $this->year, $this->month, $this->wilker_id
                                            )->get());

        $this->reeksporTotalVolume      =  parent::castNumberFormat(RekapReeksporKh::countRekapitulasi(
                                                $this->year, $this->month, $this->wilker_id
                                            )->get());

        $this->serahTerimaTotalVolume   =  parent::castNumberFormat(RekapSerahTerimaKh::countRekapitulasi(
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
        $this->pnbpDomas        =   RekapDomasKh::countTotalPnbp(
                                        $this->year, $this->month, $this->wilker_id
                                    )->pnbp;

        $this->pnbpDokel        =   RekapDokelKh::countTotalPnbp(
                                        $this->year, $this->month, $this->wilker_id
                                    )->pnbp;

        $this->pnbpEkspor       =   RekapEksporKh::countTotalPnbp(
                                        $this->year, $this->month, $this->wilker_id
                                    )->pnbp;

        $this->pnbpImpor        =   RekapImporKh::countTotalPnbp(
                                        $this->year, $this->month, $this->wilker_id
                                    )->pnbp;

        $this->pnbpReekspor     =   RekapReeksporKh::countTotalPnbp(
                                        $this->year, $this->month, $this->wilker_id
                                    )->pnbp;

        $this->pnbpSerahTerima  =   RekapSerahTerimaKh::countTotalPnbp(
                                        $this->year, $this->month, $this->wilker_id
                                    )->pnbp;

        return $this;
    }

    /**
     * Mengatur Total Total Pemakaian Dokumen semua kegiatan |
     * memakai local scope pada model
     *
     * @return void
     */
    public function pemakaianDokumen()
    {
        return  DokumenKh::countPemakaianDokumen(
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
        return  PembatalanDokKh::countPembatalanDokumen(
                    $this->year, $this->month, $this->wilker_id
                )->get();
    }

    /**
     * Mengatur Total Frekuensi Per Bulan
     * memakai local scope pada model
     *
     * @return void
     */
    public function frekuensiKomoditiPerMonthKh()
    {
        $this->frekuensiKomoditiDokel           =   RekapDokelKh::countFrekuensiKomoditi(
                                                        $this->year, $this->month, $this->wilker_id
                                                    )->get();

        $this->frekuensiKomoditiDomas           =   RekapDomasKh::countFrekuensiKomoditi(
                                                        $this->year, $this->month, $this->wilker_id
                                                    )->get();

        $this->frekuensiKomoditiEkspor          =   RekapEksporKh::countFrekuensiKomoditi(
                                                        $this->year, $this->month, $this->wilker_id
                                                    )->get();

        $this->frekuensiKomoditiImpor           =   RekapImporKh::countFrekuensiKomoditi(
                                                        $this->year, $this->month, $this->wilker_id
                                                    )->get();

        $this->frekuensiKomoditiReekspor        =   RekapReeksporKh::countFrekuensiKomoditi(
                                                        $this->year, $this->month, $this->wilker_id
                                                    )->get();

        $this->frekuensiKomoditiSerahTerima     =   RekapSerahTerimaKh::countFrekuensiKomoditi(
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
    public function topFiveFrekuensiKomoditiKh()
    {
        return  [

            'dokel'         =>  RekapDokelKh::topFiveFrekuensiKomoditi(
                                    $this->year, $this->month, $this->wilker_id
                                )->get(),

            'domas'         =>  RekapDomasKh::topFiveFrekuensiKomoditi(
                                    $this->year, $this->month, $this->wilker_id
                                )->get(),

            'ekspor'        =>  RekapEksporKh::topFiveFrekuensiKomoditi(
                                    $this->year, $this->month, $this->wilker_id
                                )->get(),

            'impor'         =>  RekapImporKh::topFiveFrekuensiKomoditi(
                                    $this->year, $this->month, $this->wilker_id
                                )->get(),

            'reekspor'      =>  RekapReeksporKh::topFiveFrekuensiKomoditi(
                                    $this->year, $this->month, $this->wilker_id
                                )->get(),

            'serahterima'   =>  RekapSerahTerimaKh::topFiveFrekuensiKomoditi(
                                    $this->year, $this->month, $this->wilker_id
                                )->get(),

        ];
    }

    /**
     * Untuk API Log Pengiriman Laporan
     * DIgunakan Oleh class HomeKhController
     * menggunakan local scope pada Model Loginfo
     *
     * @param int $year, int $wilker_id
     * @return Collection of Datatables
     */
    public function log($year, $month, $wilker, $type)
    {
        $log = LogInfo::karantinaHewanType($year, $month, $wilker, $type)->get();

        return app('DataTables')::of($log)->addIndexColumn()
         ->addColumn('action', function ($data) {

            if (empty($data->rolledback_at) || $data->rolledback_at == "") {

                if (\Carbon::now() > \Carbon::parse($data->created_at)->addWeek()) {

                    $action = '-';
                    
                } else {

                    $action = '<a href="#" data-id = "'.$data->id.'" class="btn btn-danger" id="rollbackOperasionalBtn">
                            <i class="fa fa-repeat fa-fw"></i> Rollback
                        </a>';
                }       

            } else {

               $action = '-';

            }

            return $action;

        })->make(true);
    }

}