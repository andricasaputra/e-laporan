<?php

namespace App\Http\Controllers\Operasional;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Operasional\DataOperasionalKtTrait;
use App\Repositories\Operasional\DataOperasionalKtRepository as Repository;

class HomeKtController extends Controller
{
    use DataOperasionalKtTrait;

    /**
     * Untuk menyimpan instance dari object repository
     *
     * @var App\Repositories\Operasional\DataOperasionalKtRepository
     */
    private $ktRepository;

    /**
     * Untuk menyimpan parameter tahun dari url
     *
     * @var int
     */
    private $year;

    /**
     * Untuk menyimpan parameter bulan dari url
     *
     * @var int|null
     */
    private $month = null;

    /**
     * Untuk menyimpan parameter wilker_id dari url
     *
     * @var int|null
     */
    private $wilker_id = null;

    /**
     * Untuk menyatukan semua parameter yang dibutuhkan oleh route
     *
     * @var array
     */
    public $routeParams;

    /**
     * Untuk set semua property yang dibutuhkan maka perlu constructor
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->year         = $request->year ?? date('Y');

        $this->month        = $request->month;

        $this->wilker_id    = $request->wilker_id;

        $this->routeParams  = [$this->year, $this->month, $this->wilker_id];

        $this->ktRepository = new Repository($request);
    }

    /**
     * Untuk set menu di halaman home kt
     *
     * @return \Illuminate\Http\Response
     */
    public function showMenu()
    {
        return view('intern.operasional.kt.menu');
    }

    /**
     * Untuk set menu di halaman Data Operasional kt
     *
     * @return \Illuminate\Http\Response
     */
    public function showMenuDataOperasional()
    {
        return view('intern.operasional.kt.data.menu');
    }

    /**
     * Halaman upload
     *
     * @param int|null $year
     * @return \Illuminate\Http\Response
     */
    public function homeUpload(int $year = null)
    {
        return view('intern.operasional.kt.upload.home_upload');
    }

    /**
     * Halaman upload
     *
     * @return \Illuminate\Http\Response
     */
    public function homeDownload()
    {
        return view('intern.operasional.kt.download.home_download');
    }

    /**
     * Halaman Utama untuk data - data opersional dari Karantina Hewan
     *
     * @return \Illuminate\Http\Response
     */
    public function homeRekapitulasi()
    {
        return view('intern.operasional.kt.data.rekapitulasi.home')
                ->withDatas($this->rekapitulasiDataOperasionalKt());
    }

    /**
     * Halaman Utama untuk data - data opersional dari Karantina Hewan
     *
     * @return \Illuminate\Http\Response
     */
    public function homeStatistik()
    {
        return view('intern.operasional.kt.data.statistik.home')
                ->withDatas($this->statistikDataOperasionalKt());
    }

    /**
     * Halaman Utama untuk data - data opersional dari Karantina Hewan
     *
     * @return \Illuminate\Http\Response
     */
    public function statistikDetailFrekuensi()
    {
        return view('intern.operasional.kt.data.statistik.detail.frekuensi.index');
    }

    /**
     * Untuk API Dashboard E - Operasional
     *
     * @return mixed
     */
    public function dashboardApiKt()
    {
        return $this->sourecDashboardApiKt();
    }

    /**
     * Untuk API Log Pengiriman Laporan
     *
     * @param int $year 
     * @param int $month
     * @param int $wilker
     * @param string $type
     * @return \Illuminate\Http\Response
     */
    public function logApi(int $year, $month , $wilker, string $type)
    {
        return $this->ktRepository->log($year, $month, $wilker, $type);
    }

    /**
     * Untuk Menghapus data laporan yang terkirim / rollback laporan
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->ktRepository->rollback($request);

        return back()->withSuccess('Laporan Operasional Berhasil Ditarik Kembali');
    }
    
}
