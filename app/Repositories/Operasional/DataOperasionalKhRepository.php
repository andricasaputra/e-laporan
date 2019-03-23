<?php 

namespace App\Repositories\Operasional;

use Carbon\Carbon;
use App\Models\Operasional\LogInfo;
use App\Models\Operasional\DokelKh;
use App\Models\Operasional\DomasKh;
use App\Models\Operasional\ImporKh;
use App\Models\Operasional\EksporKh;
use App\Models\Operasional\ReeksporKh;
use App\Models\Operasional\SerahTerimaKh;
use App\Models\Operasional\Dokumen\PembatalanDokKh;
use App\Models\Operasional\Dokumen\PemakaianDokumenKh as DokumenKh;
use App\Models\Operasional\Dokumen\PenerimaanDokumenKh as Penerimaan;
use App\Models\Operasional\RekapitulasiKomoditiDokelKh as RekapDokelKh;
use App\Models\Operasional\RekapitulasiKomoditiDomasKh as RekapDomasKh;
use App\Models\Operasional\RekapitulasiKomoditiImporKh as RekapImporKh;
use App\Models\Operasional\RekapitulasiKomoditiEksporKh as RekapEksporKh;
use App\Models\Operasional\RekapitulasiKomoditiReeksporKh as RekapReeksporKh;
use App\Models\Operasional\RekapitulasiKomoditiSerahTerimaKh as RekapSerahTerimaKh;

class DataOperasionalKhRepository extends DataOperasionalRepositoryManager
{
    /**
     * Mengatur total frekuensi berdasarkan jenis Kegiatan 
     * penghitungan frekuensi diambil dari jumlah permohonan 
     * (bukan jumlah frekuensi komoditas)
     * memakai scope local pada Model
     *
     * @return void
     */
    public function totalFrekuensiPerKegiatan()
    {
        $this->frekuensiDomas       =  DomasKh::countFrekuensiByPermohonan($this->routeParams)->frekuensi;

        $this->frekuensiDokel       =  DokelKh::countFrekuensiByPermohonan($this->routeParams)->frekuensi;

        $this->frekuensiEkspor      =  EksporKh::countFrekuensiByPermohonan($this->routeParams)->frekuensi;

        $this->frekuensiImpor       =  ImporKh::countFrekuensiByPermohonan($this->routeParams)->frekuensi;

        $this->frekuensiReekspor    =  ReeksporKh::countFrekuensiByPermohonan($this->routeParams)->frekuensi;

        $this->frekuensiSerahTerima =  SerahTerimaKh::countFrekuensiByPermohonan($this->routeParams)->frekuensi;

        return $this;
    }

    /**
     * Mengatur total volume komoditi per satuan
     * memakai scope local pada Model
     *
     * @return mixed
     */
    public function totalVolumePerSatuan()
    {
        return  [

            'dokel'         =>  RekapDokelKh::countVolume($this->routeParams)->get(),

            'domas'         =>  RekapDomasKh::countVolume($this->routeParams)->get(),

            'ekspor'        =>  RekapEksporKh::countVolume($this->routeParams)->get(),

            'impor'         =>  RekapImporKh::countVolume($this->routeParams)->get(),

            'reekspor'      =>  RekapReeksporKh::countVolume($this->routeParams)->get(),

            'serahterima'   =>  RekapSerahTerimaKh::countVolume($this->routeParams)->get(),

        ];
    }

    /**
     * Mengatur total rekapitulasi frekuensi, volume, pnbp berdasakan komoditi
     * memakai scope local pada Model
     *
     * @return void
     */
    public function totalRekapitulasi()
    {
        $this->dokelTotalVolume         =   parent::castNumberFormat(RekapDokelKh::countRekapitulasi(
                                                $this->routeParams
                                            )->get());

        $this->domasTotalVolume         =   parent::castNumberFormat(RekapDomasKh::countRekapitulasi(
                                                $this->routeParams
                                            )->get());

        $this->eksporTotalVolume        =   parent::castNumberFormat(RekapEksporKh::countRekapitulasi(
                                                $this->routeParams
                                            )->get());

        $this->imporTotalVolume         =   parent::castNumberFormat(RekapImporKh::countRekapitulasi(
                                                $this->routeParams
                                            )->get());

        $this->reeksporTotalVolume      =   parent::castNumberFormat(RekapReeksporKh::countRekapitulasi(
                                                $this->routeParams
                                            )->get());

        $this->serahTerimaTotalVolume   =   parent::castNumberFormat(RekapSerahTerimaKh::countRekapitulasi(
                                                $this->routeParams
                                            )->get());

        return $this; 
    }


    /**
     * Mengatur Total PNBP semua kegiatan
     * memakai local scope pada model
     *
     * @return void
     */
    public function totalPnbp()
    {
        $this->pnbpDomas        =  RekapDomasKh::countTotalPnbp($this->routeParams)->pnbp;

        $this->pnbpDokel        =  RekapDokelKh::countTotalPnbp($this->routeParams)->pnbp;

        $this->pnbpEkspor       =  RekapEksporKh::countTotalPnbp($this->routeParams)->pnbp;

        $this->pnbpImpor        =  RekapImporKh::countTotalPnbp($this->routeParams)->pnbp;

        $this->pnbpReekspor     =  RekapReeksporKh::countTotalPnbp($this->routeParams)->pnbp;

        $this->pnbpSerahTerima  =  RekapSerahTerimaKh::countTotalPnbp($this->routeParams)->pnbp;

        return $this;
    }

    /**
     * Mengatur Total Frekuensi Berdasarkan Komoditas
     * memakai local scope pada model
     *
     * @return void
     */
    public function frekuensiByKomoditiKh()
    {
        $this->frekuensiKomoditiDokel           =   RekapDokelKh::countFrekuensiByKomoditi(
                                                        $this->routeParams
                                                    )->get();

        $this->frekuensiKomoditiDomas           =   RekapDomasKh::countFrekuensiByKomoditi(
                                                        $this->routeParams
                                                    )->get();

        $this->frekuensiKomoditiEkspor          =   RekapEksporKh::countFrekuensiByKomoditi(
                                                        $this->routeParams
                                                    )->get();

        $this->frekuensiKomoditiImpor           =   RekapImporKh::countFrekuensiByKomoditi(
                                                        $this->routeParams
                                                    )->get();

        $this->frekuensiKomoditiReekspor        =   RekapReeksporKh::countFrekuensiByKomoditi(
                                                        $this->routeParams
                                                    )->get();

        $this->frekuensiKomoditiSerahTerima     =   RekapSerahTerimaKh::countFrekuensiByKomoditi(
                                                        $this->routeParams
                                                    )->get();

        return $this;
    }

    /**
     * Mengatur Top Five Komoditi Berdasarkan Frekuensi
     * memakai local scope pada model
     *
     * @return array
     */
    public function topFiveFrekuensiKomoditiKh()
    {
        return  [

            'dokel'         =>  RekapDokelKh::topFiveFrekuensiKomoditi($this->routeParams)->get(),

            'domas'         =>  RekapDomasKh::topFiveFrekuensiKomoditi($this->routeParams)->get(),

            'ekspor'        =>  RekapEksporKh::topFiveFrekuensiKomoditi($this->routeParams)->get(),

            'impor'         =>  RekapImporKh::topFiveFrekuensiKomoditi($this->routeParams)->get(),

            'reekspor'      =>  RekapReeksporKh::topFiveFrekuensiKomoditi($this->routeParams)->get(),

            'serahterima'   =>  RekapSerahTerimaKh::topFiveFrekuensiKomoditi($this->routeParams)->get(),

        ];
    }

    /**
     * Mengatur Total Penerimaan Dokumen semua kegiatan
     * memakai local scope pada model
     *
     * @return mixed
     */
    public function penerimaanDokumen($excel = false)
    {
        return Penerimaan::countPenerimaanDokumen($this->routeParams, $excel);
    }

    /**
     * Mengatur Total Penerimaan Dokumen bulan sebelumnya, untuk tanggal tertentu
     * memakai local scope pada model
     *
     * @param bool $excel -> untuk pemakaian pada laporan excel, default false = tidak untuk excel
     * @return mixed
     */
    public function penerimaanDokumenBulanLalu($excel = true)
    {
        return  Penerimaan::countPenerimaanDokumen(
                    $this->bulanLalu()['year'], $this->bulanLalu()['lastMonth'], $this->wilker_id, $excel
                );
    }

    /**
     * Mengatur Total Pemakaian Dokumen semua kegiatan
     * memakai local scope pada model
     *
     * @return mixed
     */
    public function totalPenerimaanDokumen()
    {
        return Penerimaan::countTotalPemakaianDokumen($this->routeParams);
    }

    /**
     * Mengatur Total Pemakaian Dokumen semua kegiatan untuk tanggal tertentu
     * memakai local scope pada model
     *
     * @param bool $excel -> untuk pemakaian pada laporan excel, default false = tidak untuk excel
     * @return mixed
     */
    public function pemakaianDokumen($excel = false)
    {
        return DokumenKh::countPemakaianDokumen($this->routeParams, $excel)->get();
    }

    /**
     * Mengatur Total Pemakaian Dokumen bulan sebelumnya, untuk tanggal tertentu
     * memakai local scope pada model
     *
     * @param bool $excel -> untuk pemakaian pada laporan excel, default false = tidak untuk excel
     * @return mixed
     */
    public function pemakaianDokumenBulanLalu($excel = false)
    {
        return  DokumenKh::countPemakaianDokumen(
                    $this->bulanLalu()['year'], $this->bulanLalu()['lastMonth'], $this->wilker_id, $excel
                )->get();
    }

    /**
     * Mengatur Total Pemakaian Dokumen semua kegiatan
     * memakai local scope pada model
     *
     * @return mixed
     */
    public function totalPemakaianDokumen()
    {
        return DokumenKh::countTotalPemakaianDokumen($this->routeParams)->get();
    }

    /**
     * Mengatur Total Pembatalan Dokumen semua kegiatan
     * memakai local scope pada model
     *
     * @return mixed
     */
    public function pembatalanDokumen()
    {
        return  PembatalanDokKh::getJumlahKhDokumen(
                    ['year' => $this->year, 'month' => $this->month, 'wilkerId' => $this->wilker_id]
                );
    }

    /**
     * Atur bulan lalu untuk keperluan penerimaan dokumen
     *
     * @return mixed
     */
    private function bulanLalu()
    {
        if ($this->month == 'all') {

            $lastMonth = Carbon::parse($this->year)->subMonth()->month;

            $year      = Carbon::parse($this->year)->subYear()->year;

        } else {

            $lastMonth = Carbon::parse($this->year .'-'. $this->month)->subMonth()->month;

            if ($this->month == 1) {

                $year  = Carbon::parse($this->year .'-'. $this->month)->subYear()->year;

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
     * DIgunakan Oleh class HomeKhController
     * menggunakan local scope pada Model Loginfo
     *
     * @param int|null $year
     * @param int|null $month
     * @param int|null $wilkerId
     * @return mixed
     */
    public function log($year, $month, $wilker, $type)
    {
        $log = LogInfo::karantinaHewanType($year, $month, $wilker, $type)->get();

        return datatables($log)->addIndexColumn()->addColumn('action', function ($datas) {

            /*
            * Hilangkan tombol rollback jika :
            * 1. laporan sudah pernah di rollback sebelumnya,
            * 2. laporan telah diupload lebih dari seminggu yang lalu,
            *    karena jika sudah lebih dari seminggu, laporan kita asumsikan valid
            *    dan tidak dapat di rollback kembali
            */
            return $datas->when(is_null($datas->rolledback_at) && is_null($datas->status) , function() use ($datas){

                return  now() > Carbon::parse($datas->created_at)->addWeek() 
                        ? '-'
                        :'<a href="#" data-id = "'.$datas->id.'" class="btn btn-danger" id="rollbackOperasionalBtn">
                            <i class="fa fa-repeat fa-fw"></i> Rollback
                         </a>';

            }, function() {

                return '-';

            });

        })->make(true);
    }

}