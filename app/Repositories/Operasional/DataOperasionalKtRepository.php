<?php 

namespace App\Repositories\Operasional;

<<<<<<< HEAD
use Carbon\Carbon;
=======
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
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
use App\Models\Operasional\RekapitulasiKomoditiDokelKt as RekapDokelKt;
use App\Models\Operasional\RekapitulasiKomoditiDomasKt as RekapDomasKt;
use App\Models\Operasional\RekapitulasiKomoditiImporKt as RekapImporKt;
use App\Models\Operasional\RekapitulasiKomoditiEksporKt as RekapEksporKt;
use App\Models\Operasional\RekapitulasiKomoditiReeksporKt as RekapReeksporKt;
use App\Models\Operasional\RekapitulasiKomoditiSerahTerimaKt as RekapSerahTerimaKt;

class DataOperasionalKtRepository extends DataOperasionalRepositoryManager
{
    /**
     * Mengatur total frekuensi berdasarkan jenis Kegiatan 
     * penghitungan frekuensi diambil dari jumlah permohonan 
     * (bukan jumlah frekuensi komoditas)
     * memakai scope local pada Model
     *
<<<<<<< HEAD
     * @return void
=======
     * @return array
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
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

            'dokel'         =>  RekapDokelKt::countVolume($this->routeParams)->get(),

            'domas'         =>  RekapDomasKt::countVolume($this->routeParams)->get(),

            'ekspor'        =>  RekapEksporKt::countVolume($this->routeParams)->get(),

            'impor'         =>  RekapImporKt::countVolume($this->routeParams)->get(),

            'reekspor'      =>  RekapReeksporKt::countVolume($this->routeParams)->get(),

            'serahterima'   =>  RekapSerahTerimaKt::countVolume($this->routeParams)->get(),

        ];
    }

    /**
     * Mengatur total rekapitulasi frekuensi, volume, pnbp berdasakan komoditi
     * memakai scope local pada Model
     *
<<<<<<< HEAD
     * @return void
=======
     * @return this
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function totalRekapitulasi()
    {
        $this->dokelTotalVolume         =   parent::castNumberFormat(RekapDokelKt::countRekapitulasi(
                                                $this->routeParams
                                            )->get());

        $this->domasTotalVolume         =   parent::castNumberFormat(RekapDomasKt::countRekapitulasi(
                                                $this->routeParams
                                            )->get());

        $this->eksporTotalVolume        =   parent::castNumberFormat(RekapEksporKt::countRekapitulasi(
                                                $this->routeParams
                                            )->get());

        $this->imporTotalVolume         =   parent::castNumberFormat(RekapImporKt::countRekapitulasi(
                                                $this->routeParams
                                            )->get());

        $this->reeksporTotalVolume      =   parent::castNumberFormat(RekapReeksporKt::countRekapitulasi(
                                                $this->routeParams
                                            )->get());

        $this->serahTerimaTotalVolume   =   parent::castNumberFormat(RekapSerahTerimaKt::countRekapitulasi(
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
        $this->pnbpDomas        =  RekapDomasKt::countTotalPnbp($this->routeParams)->pnbp;

        $this->pnbpDokel        =  RekapDokelKt::countTotalPnbp($this->routeParams)->pnbp;

        $this->pnbpEkspor       =  RekapEksporKt::countTotalPnbp($this->routeParams)->pnbp;

        $this->pnbpImpor        =  RekapImporKt::countTotalPnbp($this->routeParams)->pnbp;

        $this->pnbpReekspor     =  RekapReeksporKt::countTotalPnbp($this->routeParams)->pnbp;

        $this->pnbpSerahTerima  =  RekapSerahTerimaKt::countTotalPnbp($this->routeParams)->pnbp;

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
        $this->frekuensiKomoditiDokel           =   RekapDokelKt::countFrekuensiByKomoditi(
                                                        $this->routeParams
                                                    )->get();

        $this->frekuensiKomoditiDomas           =   RekapDomasKt::countFrekuensiByKomoditi(
                                                        $this->routeParams
                                                    )->get();

        $this->frekuensiKomoditiEkspor          =   RekapEksporKt::countFrekuensiByKomoditi(
                                                        $this->routeParams
                                                    )->get();

        $this->frekuensiKomoditiImpor           =   RekapImporKt::countFrekuensiByKomoditi(
                                                        $this->routeParams
                                                    )->get();

        $this->frekuensiKomoditiReekspor        =   RekapReeksporKt::countFrekuensiByKomoditi(
                                                        $this->routeParams
                                                    )->get();

        $this->frekuensiKomoditiSerahTerima     =   RekapSerahTerimaKt::countFrekuensiByKomoditi(
                                                        $this->routeParams
                                                    )->get();

        return $this;
    }

    /**
     * Mengatur Top Five Komoditi Berdasarkan Frekuensi
     * memakai local scope pada model
     *
<<<<<<< HEAD
     * @return array
=======
     * @return void
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function topFiveFrekuensiKomoditiKt()
    {
        return  [

            'dokel'         =>  RekapDokelKt::topFiveFrekuensiKomoditi($this->routeParams)->get(),

            'domas'         =>  RekapDomasKt::topFiveFrekuensiKomoditi($this->routeParams)->get(),

            'ekspor'        =>  RekapEksporKt::topFiveFrekuensiKomoditi($this->routeParams)->get(),

            'impor'         =>  RekapImporKt::topFiveFrekuensiKomoditi($this->routeParams)->get(),

            'reekspor'      =>  RekapReeksporKt::topFiveFrekuensiKomoditi($this->routeParams)->get(),

            'serahterima'   =>  RekapSerahTerimaKt::topFiveFrekuensiKomoditi($this->routeParams)->get(),

        ];
    }

    /**
     * Mengatur Total Penerimaan Dokumen semua kegiatan
     * memakai local scope pada model
     *
<<<<<<< HEAD
     * @return mixed
=======
     * @return void
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
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
<<<<<<< HEAD
     * @return mixed
=======
     * @return array
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
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
<<<<<<< HEAD
     * @return mixed
=======
     * @return array
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
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
<<<<<<< HEAD
     * @return mixed
=======
     * @return array
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
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
<<<<<<< HEAD
     * @return mixed
=======
     * @return array
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function pemakaianDokumenBulanLalu($excel = false)
    {
        return  DokumenKt::countPemakaianDokumen(
                    $this->bulanLalu()['year'], $this->bulanLalu()['lastMonth'], $this->wilker_id, $excel
                )->get();
    }

    /**
     * Mengatur Total Pemakaian Dokumen semua kegiatan
     * memakai local scope pada model
     *
<<<<<<< HEAD
     * @return mixed
=======
     * @return array
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function totalPemakaianDokumen()
    {
        return DokumenKt::countTotalPemakaianDokumen($this->routeParams)->get();
    }

    /**
     * Mengatur Total Pembatalan Dokumen semua kegiatan
     * memakai local scope pada model
     *
<<<<<<< HEAD
     * @return mixed
=======
     * @return void
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function pembatalanDokumen()
    {
        return  PembatalanDokKt::getJumlahKtDokumen(
                    ['year' => $this->year, 'month' => $this->month, 'wilkerId' => $this->wilker_id]
                );
    }

    /**
     * Atur bulan lalu untuk keperluan penerimaan dokumen
     *
<<<<<<< HEAD
     * @return mixed
=======
     * @return array
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    private function bulanLalu()
    {
        if ($this->month == 'all') {

<<<<<<< HEAD
            $lastMonth = Carbon::parse($this->year)->subMonth()->month;

            $year      = Carbon::parse($this->year)->subYear()->year;

        } else {

            $lastMonth = Carbon::parse($this->year .'-'. $this->month)->subMonth()->month;

            if ($this->month == 1) {

                $year  = Carbon::parse($this->year .'-'. $this->month)->subYear()->year;
=======
            $lastMonth = \Carbon::parse($this->year)->subMonth()->month;

            $year      = \Carbon::parse($this->year)->subYear()->year;

        } else {

            $lastMonth = \Carbon::parse($this->year .'-'. $this->month)->subMonth()->month;

            if ($this->month == 1) {

                $year  = \Carbon::parse($this->year .'-'. $this->month)->subYear()->year;
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41

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
<<<<<<< HEAD
     * @param int|null $year
     * @param int|null $month
     * @param int|null $wilkerId
     * @return mixed
=======
     * @param int $year, int $wilker_id
     * @return Collection of Datatables
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
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

<<<<<<< HEAD
                return  now() > Carbon::parse($datas->created_at)->addWeek() 
=======
                return  now() > \Carbon::parse($datas->created_at)->addWeek() 
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
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