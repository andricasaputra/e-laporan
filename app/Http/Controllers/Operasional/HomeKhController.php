<?php

namespace App\Http\Controllers\Operasional;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Operasional\DataOperasionalKhTrait;
use App\Repositories\Operasional\DataOperasionalKhRepository as Repository;

class HomeKhController extends Controller
{
    use DataOperasionalKhTrait;

    /**
     * Untuk menyimpan instance dari object repository
     *
     * @var App\Repositories\Operasional\DataOperasionalKhRepository
     */
    private $khRepository;

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

        $this->khRepository = new Repository($request);
    }

    /**
     * Untuk set menu di halaman home KH
     *
     * @return \Illuminate\Http\Response
     */
    public function showMenu()
    {
        return view('intern.operasional.kh.menu');
    }

    /**
     * Untuk set menu di halaman Data Operasional KH
     *
     * @return \Illuminate\Http\Response
     */
    public function showMenuDataOperasional()
    {
        return view('intern.operasional.kh.data.menu');
    }

    /**
     * Halaman upload
     *
     * @param int|null $year
     * @return \Illuminate\Http\Response
     */
    public function homeUpload(int $year = null)
    {
        return view('intern.operasional.kh.upload.home_upload');
    }

    /**
     * Halaman upload
     *
     * @param int|null $year
     * @return \Illuminate\Http\Response
     */
    public function homeDownload()
    {
        return view('intern.operasional.kh.download.home_download');
    }

    /**
     * Halaman Utama untuk data - data opersional dari Karantina Hewan
     *
     * @return \Illuminate\Http\Response
     */
    public function homeRekapitulasi()
    {
        return view('intern.operasional.kh.data.rekapitulasi.home')
                ->withDatas($this->rekapitulasiDataOperasionalKh());
    }

    /**
     * Halaman Utama untuk data - data opersional dari Karantina Hewan
     *
     * @return \Illuminate\Http\Response
     */
    public function homeStatistik()
    {
        return view('intern.operasional.kh.data.statistik.home')
                ->withDatas($this->statistikDataOperasionalKh());
    }

    /**
     * Halaman Utama untuk data - data opersional dari Karantina Hewan
     *
     * @return \Illuminate\Http\Response)
     */
    public function statistikDetailFrekuensi()
    {
        return view('intern.operasional.kh.data.statistik.detail.frekuensi.index');
    }

    /**
     * Untuk API Dashboard E - Operasional
     *
     * @return array
     */
    public function dashboardApiKh()
    {
        return $this->sourecDashboardApiKh();
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
        return $this->khRepository->log($year, $month, $wilker, $type);
    }

    /**
     * Untuk Menghapus data laporan yang terkirim / rollback laporan
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->khRepository->rollback($request);

        return back()->withSuccess('Laporan Operasional Berhasil Ditarik Kembali');
    }
    
}
