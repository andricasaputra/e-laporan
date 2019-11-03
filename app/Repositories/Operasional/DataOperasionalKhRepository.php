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

            'dokel'         =>  DokelKh::countVolume($this->routeParams)->get(),

            'domas'         =>  DomasKh::countVolume($this->routeParams)->get(),

            'ekspor'        =>  EksporKh::countVolume($this->routeParams)->get(),

            'impor'         =>  ImporKh::countVolume($this->routeParams)->get(),

            'reekspor'      =>  ReeksporKh::countVolume($this->routeParams)->get(),

            'serahterima'   =>  SerahTerimaKh::countVolume($this->routeParams)->get(),

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
        $this->dokelTotalVolume         =   parent::castNumberFormat(DokelKh::countRekapitulasi(
                                                $this->routeParams
                                            )->get());

        $this->domasTotalVolume         =   parent::castNumberFormat(DomasKh::countRekapitulasi(
                                                $this->routeParams
                                            )->get());

        $this->eksporTotalVolume        =   parent::castNumberFormat(EksporKh::countRekapitulasi(
                                                $this->routeParams
                                            )->get());

        $this->imporTotalVolume         =   parent::castNumberFormat(ImporKh::countRekapitulasi(
                                                $this->routeParams
                                            )->get());

        $this->reeksporTotalVolume      =   parent::castNumberFormat(ReeksporKh::countRekapitulasi(
                                                $this->routeParams
                                            )->get());

        $this->serahTerimaTotalVolume   =   parent::castNumberFormat(SerahTerimaKh::countRekapitulasi(
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
        $this->pnbpDomas        =  DomasKh::countTotalPnbp($this->routeParams)->pnbp;

        $this->pnbpDokel        =  DokelKh::countTotalPnbp($this->routeParams)->pnbp;

        $this->pnbpEkspor       =  EksporKh::countTotalPnbp($this->routeParams)->pnbp;

        $this->pnbpImpor        =  ImporKh::countTotalPnbp($this->routeParams)->pnbp;

        $this->pnbpReekspor     =  ReeksporKh::countTotalPnbp($this->routeParams)->pnbp;

        $this->pnbpSerahTerima  =  SerahTerimaKh::countTotalPnbp($this->routeParams)->pnbp;

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
        $this->frekuensiKomoditiDokel           =   DokelKh::countFrekuensiByKomoditi(
                                                        $this->routeParams
                                                    )->get();

        $this->frekuensiKomoditiDomas           =   DomasKh::countFrekuensiByKomoditi(
                                                        $this->routeParams
                                                    )->get();

        $this->frekuensiKomoditiEkspor          =   EksporKh::countFrekuensiByKomoditi(
                                                        $this->routeParams
                                                    )->get();

        $this->frekuensiKomoditiImpor           =   ImporKh::countFrekuensiByKomoditi(
                                                        $this->routeParams
                                                    )->get();

        $this->frekuensiKomoditiReekspor        =   ReeksporKh::countFrekuensiByKomoditi(
                                                        $this->routeParams
                                                    )->get();

        $this->frekuensiKomoditiSerahTerima     =   SerahTerimaKh::countFrekuensiByKomoditi(
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

            'dokel'         =>  DokelKh::topFiveFrekuensiKomoditi($this->routeParams)->get(),

            'domas'         =>  DomasKh::topFiveFrekuensiKomoditi($this->routeParams)->get(),

            'ekspor'        =>  EksporKh::topFiveFrekuensiKomoditi($this->routeParams)->get(),

            'impor'         =>  ImporKh::topFiveFrekuensiKomoditi($this->routeParams)->get(),

            'reekspor'      =>  ReeksporKh::topFiveFrekuensiKomoditi($this->routeParams)->get(),

            'serahterima'   =>  SerahTerimaKh::topFiveFrekuensiKomoditi($this->routeParams)->get(),

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
        return  PembatalanDokKh::getJumlahPembatalanKhDokumen(
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