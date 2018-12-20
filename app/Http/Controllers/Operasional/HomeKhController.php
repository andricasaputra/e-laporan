<?php

namespace App\Http\Controllers\Operasional;

use App\Models\Wilker;
use Illuminate\Http\Request;
use App\Repositories\Operasional\DataOperasionalKhRepository as Repository;

class HomeKhController extends BaseOperasionalController
{
    use DataOperasionalKhTrait;

    /**
     * Untuk menyimpan instance dari object repository
     *
     * @var ObjectRepository
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
     * @param DataOperasionalKhRepository $repository, Request $request
     * @return void
     */
    public function __construct(Repository $repository, Request $request)
    {
        $this->khRepository = $repository;

        $this->year         = $request->route()->parameter('year') ?? date('Y');

        $this->month        = $request->route()->parameter('month');

        $this->wilker_id    = $request->route()->parameter('wilker_id');

        $this->params       = [$this->year, $this->month, $this->wilker_id];

        $this->khRepository->setDateAndWilker($this->year, $this->month, $this->wilker_id);
    }

    /**
     * Untuk set menu di halaman home KH
     *
     * @return view -> page show menu (data, upload, download)
     */
    public function showMenu()
    {
        return view('intern.operasional.kh.menu');
    }

    /**
     * Untuk set menu di halaman Data Operasional KH
     *
     * @return view -> page show menu data operasionla
     */
    public function showMenuDataOperasional()
    {
        return view('intern.operasional.kh.data.menu');
    }

    /**
     * Halaman upload
     *
     * @param int $ year nullable
     * @return view -> page upload (domas, dokel, ekspor, impor)
     */
    public function homeUpload(int $year = null)
    {
        return view('intern.operasional.kh.upload.home_upload');
    }

    /**
     * Halaman Utama untuk data - data opersional dari Karantina Hewan
     *
     * @return view -> Data Operasional (statistik, grafik, rekapitulasi)
     */
    public function homeRekapitulasi()
    {
        return view('intern.operasional.kh.data.rekapitulasi.home')
                ->with('datas', $this->rekapitulasiDataOperasionalKh())
                ->with('wilkers', Wilker::where('id', '!=', 1)->get());
    }

    /**
     * Halaman Utama untuk data - data opersional dari Karantina Hewan
     *
     * @return view -> Data Operasional (statistik, grafik, rekapitulasi)
     */
    public function homeStatistik()
    {
        return view('intern.operasional.kh.data.statistik.home')
                ->with('datas', $this->statistikDataOperasionalKh())
                ->with('wilkers', Wilker::where('id', '!=', 1)->get());
    }

    /**
     * Halaman Utama untuk data - data opersional dari Karantina Hewan
     *
     * @return view -> Data Operasional (statistik, grafik, rekapitulasi)
     */
    public function statistikDetailFrekuensi()
    {
        return view('intern.operasional.kh.data.statistik.detail.frekuensi.index');
    }

    /**
     * Untuk API Log Pengiriman Laporan
     *
     * @param int $year, $wilker_id 
     * @return view -> Data Operasional (statistik, grafik, rekapitulasi)
     */
    public function logApi(int $year, int $wilker)
    {
        return $this->khRepository->log($year, $wilker);
    }

    /**
     * Untuk Menghapus data laporan yang terkirim / rollback laporan
     *
     * @param request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        $this->khRepository->rollback($request);

        return redirect()->route('kh.homeupload')
                ->with('success', 'Laporan Operasional Berhasil Ditarik Kembali');
    }
    
}
