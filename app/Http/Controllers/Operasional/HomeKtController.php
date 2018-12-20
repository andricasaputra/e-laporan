<?php

namespace App\Http\Controllers\Operasional;

use App\Models\Wilker;
use Illuminate\Http\Request;
use App\Repositories\Operasional\DataOperasionalKtRepository as Repository;

class HomeKtController extends BaseOperasionalController
{
    use DataOperasionalKtTrait;

    /**
     * Untuk menyimpan instance dari object repository
     *
     * @var ObjectRepository
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
     * @var int / nullable
     */
    private $month = null;

    /**
     * Untuk menyimpan parameter wilker_id dari url
     *
     * @var int / nullable
     */
    private $wilker_id = null;

    /**
     * Untuk menyatukan semua parameter yang dibutuhkan oleh route menjadi 1
     *
     * @var array
     */
    public $params;

    /**
     * Untuk set semua property yang dibutuhkan maka perlu constructor
     *
     * @param DataOperasionalKtRepository $repository, Request $request
     * @return void
     */
    public function __construct(Repository $repository, Request $request)
    {
        $this->ktRepository = $repository;

        $this->year         = $request->route()->parameter('year') ?? date('Y');

        $this->month        = $request->route()->parameter('month');

        $this->wilker_id    = $request->route()->parameter('wilker_id');

        $this->params       = [$this->year, $this->month, $this->wilker_id];

        $this->ktRepository->setDateAndWilker($this->year, $this->month, $this->wilker_id);
    }

    /**
     * Untuk set menu di halaman home kt
     *
     * @return view -> page show menu (data, upload, download)
     */
    public function showMenu()
    {
        return view('intern.operasional.kt.menu');
    }

    /**
     * Untuk set menu di halaman Data Operasional kt
     *
     * @return view -> page show menu data operasionla
     */
    public function showMenuDataOperasional()
    {
        return view('intern.operasional.kt.data.menu');
    }

    /**
     * Halaman upload
     *
     * @param int $ year nullable
     * @return view -> page upload (domas, dokel, ekspor, impor)
     */
    public function homeUpload(int $year = null)
    {
        return view('intern.operasional.kt.upload.home_upload');
    }

    /**
     * Halaman Utama untuk data - data opersional dari Karantina Hewan
     *
     * @return view -> Data Operasional (statistik, grafik, rekapitulasi)
     */
    public function homeRekapitulasi()
    {
        return view('intern.operasional.kt.data.rekapitulasi.home')
                ->with('datas', $this->rekapitulasiDataOperasionalKt())
                ->with('wilkers', Wilker::where('id', '!=', 1)->get());
    }

    /**
     * Halaman Utama untuk data - data opersional dari Karantina Hewan
     *
     * @return view -> Data Operasional (statistik, grafik, rekapitulasi)
     */
    public function homeStatistik()
    {
        return view('intern.operasional.kt.data.statistik.home')
                ->with('datas', $this->statistikDataOperasionalKt())
                ->with('wilkers', Wilker::where('id', '!=', 1)->get());
    }

    /**
     * Halaman Utama untuk data - data opersional dari Karantina Hewan
     *
     * @return view -> Data Operasional (statistik, grafik, rekapitulasi)
     */
    public function statistikDetailFrekuensi()
    {
        return view('intern.operasional.kt.data.statistik.detail.frekuensi.index');
    }

    /**
     * Untuk API Log Pengiriman Laporan
     *
     * @param int $year, $wilker_id 
     * @return view -> Data Operasional (statistik, grafik, rekapitulasi)
     */
    public function logApi(int $year, int $wilker)
    {
        return $this->ktRepository->log($year, $wilker);
    }

    /**
     * Untuk Menghapus data laporan yang terkirim / rollback laporan
     *
     * @param request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        $this->ktRepository->rollback($request);

        return redirect()->route('kt.homeupload')
                ->with('success', 'Laporan Operasional Berhasil Ditarik Kembali');
    }
    

}
