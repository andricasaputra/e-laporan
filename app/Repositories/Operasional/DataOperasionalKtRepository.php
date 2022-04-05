<?php 

namespace App\Repositories\Operasional;

use Carbon\Carbon;
use App\Models\Operasional\LogInfo;
use App\Models\Operasional\DokelKt;
use App\Models\Operasional\DomasKt;
use App\Models\Operasional\ImporKt;
use App\Models\Operasional\EksporKt;
use App\Models\Operasional\ReeksporKt;
use App\Models\Operasional\SerahTerimaKt;
use App\Models\Operasional\Dokumen\PembatalanDokKt;
use App\Models\Operasional\Dokumen\PemakaianDokumenKt as DokumenKt;
use App\Models\Operasional\Dokumen\PenerimaanDokumenKt as Penerimaan;

class DataOperasionalKtRepository extends DataOperasionalRepositoryManager
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
        $this->frekuensiDomas       =  DomasKt::countFrekuensiByPermohonan($this->routeParams)->frekuensi;

        $this->frekuensiDokel       =  DokelKt::countFrekuensiByPermohonan($this->routeParams)->frekuensi;

        $this->frekuensiEkspor      =  EksporKt::countFrekuensiByPermohonan($this->routeParams)->frekuensi;

        $this->frekuensiImpor       =  ImporKt::countFrekuensiByPermohonan($this->routeParams)->frekuensi;

        $this->frekuensiReekspor    =  ReeksporKt::countFrekuensiByPermohonan($this->routeParams)->frekuensi;

        $this->frekuensiSerahTerima =  SerahTerimaKt::countFrekuensiByPermohonan($this->routeParams)->frekuensi;

        return $this;
    }

    /**
     * Mengatur total volume komoditi per satuan
     * memakai scope local pada Model
     *
     * @return array
     */
    public function totalVolumePerSatuan()
    {
        return  [

            'dokel'         =>  DokelKt::countVolume($this->routeParams)->get(),

            'domas'         =>  DomasKt::countVolume($this->routeParams)->get(),

            'ekspor'        =>  EksporKt::countVolume($this->routeParams)->get(),

            'impor'         =>  ImporKt::countVolume($this->routeParams)->get(),

            'reekspor'      =>  ReeksporKt::countVolume($this->routeParams)->get(),

            'serahterima'   =>  SerahTerimaKt::countVolume($this->routeParams)->get(),

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
        $this->dokelTotalVolume         =   parent::castNumberFormat(DokelKt::countRekapitulasi(
                                                $this->routeParams
                                            )->get());

        $this->domasTotalVolume         =   parent::castNumberFormat(DomasKt::countRekapitulasi(
                                                $this->routeParams
                                            )->get());

        $this->eksporTotalVolume        =   parent::castNumberFormat(EksporKt::countRekapitulasi(
                                                $this->routeParams
                                            )->get());

        $this->imporTotalVolume         =   parent::castNumberFormat(ImporKt::countRekapitulasi(
                                                $this->routeParams
                                            )->get());

        $this->reeksporTotalVolume      =   parent::castNumberFormat(ReeksporKt::countRekapitulasi(
                                                $this->routeParams
                                            )->get());

        $this->serahTerimaTotalVolume   =   parent::castNumberFormat(SerahTerimaKt::countRekapitulasi(
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
        $this->pnbpDomas        =  DomasKt::countTotalPnbp($this->routeParams)->pnbp;

        $this->pnbpDokel        =  DokelKt::countTotalPnbp($this->routeParams)->pnbp;

        $this->pnbpEkspor       =  EksporKt::countTotalPnbp($this->routeParams)->pnbp;

        $this->pnbpImpor        =  ImporKt::countTotalPnbp($this->routeParams)->pnbp;

        $this->pnbpReekspor     =  ReeksporKt::countTotalPnbp($this->routeParams)->pnbp;

        $this->pnbpSerahTerima  =  SerahTerimaKt::countTotalPnbp($this->routeParams)->pnbp;

        return $this;
    }

    /**
     * Mengatur Total Frekuensi Berdasarkan Komoditas
     * memakai local scope pada model
     *
     * @return void
     */
    public function frekuensiByKomoditiKt()
    {
        $this->frekuensiKomoditiDokel           =   DokelKt::countFrekuensiByKomoditi(
                                                        $this->routeParams
                                                    )->get();

        $this->frekuensiKomoditiDomas           =   DomasKt::countFrekuensiByKomoditi(
                                                        $this->routeParams
                                                    )->get();

        $this->frekuensiKomoditiEkspor          =   EksporKt::countFrekuensiByKomoditi(
                                                        $this->routeParams
                                                    )->get();

        $this->frekuensiKomoditiImpor           =   ImporKt::countFrekuensiByKomoditi(
                                                        $this->routeParams
                                                    )->get();

        $this->frekuensiKomoditiReekspor        =   ReeksporKt::countFrekuensiByKomoditi(
                                                        $this->routeParams
                                                    )->get();

        $this->frekuensiKomoditiSerahTerima     =   SerahTerimaKt::countFrekuensiByKomoditi(
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
    public function topFiveFrekuensiKomoditiKt()
    {
        return  [

            'dokel'         =>  DokelKt::topFiveFrekuensiKomoditi($this->routeParams)->get(),

            'domas'         =>  DomasKt::topFiveFrekuensiKomoditi($this->routeParams)->get(),

            'ekspor'        =>  EksporKt::topFiveFrekuensiKomoditi($this->routeParams)->get(),

            'impor'         =>  ImporKt::topFiveFrekuensiKomoditi($this->routeParams)->get(),

            'reekspor'      =>  ReeksporKt::topFiveFrekuensiKomoditi($this->routeParams)->get(),

            'serahterima'   =>  SerahTerimaKt::topFiveFrekuensiKomoditi($this->routeParams)->get(),

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
        return DokumenKt::countPemakaianDokumen($this->routeParams, $excel)->get();
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
        return  DokumenKt::countPemakaianDokumen(
            [
                $this->bulanLalu()['year'], 
                $this->bulanLalu()['lastMonth'], 
                $this->wilker_id
            ], 
            $excel
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
        return DokumenKt::countTotalPemakaianDokumen($this->routeParams)->get();
    }

    /**
     * Mengatur Total Pembatalan Dokumen semua kegiatan
     * memakai local scope pada model
     *
     * @return mixed
     */
    public function pembatalanDokumen()
    {
        return  PembatalanDokKt::getJumlahPembatalanKtDokumen(
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
     * DIgunakan Oleh class HomeKtController
     * menggunakan local scope pada Model Loginfo
     *
     * @param int|null $year
     * @param int|null $month
     * @param int|null $wilkerId
     * @return mixed
     */
    public function log($year, $month, $wilker, $type)
    {
        $log = LogInfo::karantinaTumbuhanType($year, $month, $wilker, $type)->get();
        
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