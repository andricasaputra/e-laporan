<?php

namespace App\Http\Controllers\Operasional;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
<<<<<<< HEAD
use App\Traits\Operasional\DataOperasionalKhTrait;
=======
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
use App\Repositories\Operasional\DataOperasionalKhRepository as Repository;

class HomeKhController extends Controller
{
    use DataOperasionalKhTrait;

    /**
     * Untuk menyimpan instance dari object repository
     *
<<<<<<< HEAD
     * @var App\Repositories\Operasional\DataOperasionalKhRepository
=======
     * @var ObjectRepository
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
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
<<<<<<< HEAD
     * @var int|null
=======
     * @var int / nullable
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    private $month = null;

    /**
     * Untuk menyimpan parameter wilker_id dari url
     *
<<<<<<< HEAD
     * @var int|null
=======
     * @var int / nullable
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    private $wilker_id = null;

    /**
<<<<<<< HEAD
     * Untuk menyatukan semua parameter yang dibutuhkan oleh route
=======
     * Untuk menyatukan semua parameter yang dibutuhkan oleh route menjadi 1
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     *
     * @var array
     */
    public $routeParams;

    /**
     * Untuk set semua property yang dibutuhkan maka perlu constructor
     *
<<<<<<< HEAD
     * @param \Illuminate\Http\Request $request
=======
     * @param DataOperasionalKhRepository $repository, Request $request
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
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
<<<<<<< HEAD
     * @return \Illuminate\Http\Response
=======
     * @return view -> page show menu (data, upload, download)
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function showMenu()
    {
        return view('intern.operasional.kh.menu');
    }

    /**
     * Untuk set menu di halaman Data Operasional KH
     *
<<<<<<< HEAD
     * @return \Illuminate\Http\Response
=======
     * @return view -> page show menu data operasionla
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function showMenuDataOperasional()
    {
        return view('intern.operasional.kh.data.menu');
    }

    /**
     * Halaman upload
     *
<<<<<<< HEAD
     * @param int|null $year
     * @return \Illuminate\Http\Response
=======
     * @param int $ year nullable
     * @return view -> page upload (domas, dokel, ekspor, impor)
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function homeUpload(int $year = null)
    {
        return view('intern.operasional.kh.upload.home_upload');
    }

    /**
     * Halaman upload
     *
<<<<<<< HEAD
     * @param int|null $year
     * @return \Illuminate\Http\Response
=======
     * @param int $ year nullable
     * @return view -> page upload (domas, dokel, ekspor, impor)
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function homeDownload()
    {
        return view('intern.operasional.kh.download.home_download');
    }

    /**
     * Halaman Utama untuk data - data opersional dari Karantina Hewan
     *
<<<<<<< HEAD
     * @return \Illuminate\Http\Response
=======
     * @return view -> Data Operasional (statistik, grafik, rekapitulasi)
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function homeRekapitulasi()
    {
        return view('intern.operasional.kh.data.rekapitulasi.home')
                ->withDatas($this->rekapitulasiDataOperasionalKh());
    }

    /**
     * Halaman Utama untuk data - data opersional dari Karantina Hewan
     *
<<<<<<< HEAD
     * @return \Illuminate\Http\Response
=======
     * @return view -> Data Operasional (statistik, grafik, rekapitulasi)
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function homeStatistik()
    {
        return view('intern.operasional.kh.data.statistik.home')
                ->withDatas($this->statistikDataOperasionalKh());
    }

    /**
     * Halaman Utama untuk data - data opersional dari Karantina Hewan
     *
<<<<<<< HEAD
     * @return \Illuminate\Http\Response)
=======
     * @return view -> Data Operasional (statistik, grafik, rekapitulasi)
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
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
<<<<<<< HEAD
     * @param int $year 
     * @param int $month
     * @param int $wilker
     * @param string $type
     * @return \Illuminate\Http\Response
=======
     * @param int $year, $wilker_id 
     * @return view -> Data Operasional (statistik, grafik, rekapitulasi)
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function logApi(int $year, $month , $wilker, string $type)
    {
        return $this->khRepository->log($year, $month, $wilker, $type);
    }

    /**
     * Untuk Menghapus data laporan yang terkirim / rollback laporan
     *
<<<<<<< HEAD
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
=======
     * @param request $request
     * @return void
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
     */
    public function destroy(Request $request)
    {
        $this->khRepository->rollback($request);

        return back()->withSuccess('Laporan Operasional Berhasil Ditarik Kembali');
    }
    
}
