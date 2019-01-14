<?php

namespace App\Http\Controllers\Operasional\Download;

use App\Models\Wilker;
use Illuminate\Http\Request;
use App\Models\MasterPegawai;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\TableOperasionalProperty;
use App\Http\Controllers\RupiahController as Rupiah;
use App\Http\Controllers\TanggalController as Tanggal;

class DownloadController extends Controller
{
    use TableOperasionalProperty;

    /**
     * Menyimpan Instance repository yang dipakai
     *
     * @var App\Repositories\Operasional\DataOperasionalKhRepository
     */
    protected $repository;

    /**
    * Untuk Menyimpan tahun laporan
    *
    * @var int
    */
    protected $year;

    /**
    * Untuk Menyimpan bulan laporan
    *
    * @var string
    */
    protected $month;

    /**
    * Untuk Menyimpan wilker laporan
    *
    * @var string
    */
    protected $wilker_id;

    /**
    * Untuk Menyimpan nama wilker laporan
    *
    * @var string
    */
    protected $wilkerName;

    /**
    * Untuk Menyimpan jenis permohonan laporan
    *
    * @var string
    */
    protected $type;

    /**
    * Untuk Menyimpan jenis karantina laporan
    *
    * @var string
    */
    protected $karantina;

    /**
    * Untuk Menyimpan id penandatangan laporan
    *
    * @var int
    */
    protected $signatory;

    /**
    * Untuk Menyimpan pilihan semua jenis permohonan laporan
    *
    * @var array
    */
    protected $all = ['Dokel', 'Domas', 'Ekspor', 'Impor', 'Reekspor' ,'SerahTerima'];

    /**
    * Untuk Menyimpan namespace model yang akan dipakai
    *
    * @var string
    */
    protected $modelNamespace = 'App\\Models\\Operasional\\';

    /**
    * Untuk Menyimpan nama class dari model
    *
    * @var string
    */
    protected $model;

    /**
    * Set semua property
    *
    * @param Request $request
    * @return void
    */
    protected function __construct(Request $request)
    {
    	  $this->year 	    = $request->year;
    	  $this->month 	    = $request->month;
        $this->monthName  = $this->month == 'all' ? '' : 'Bulan ' . Tanggal::bulan($this->month);
    	  $this->wilker_id  = $request->wilker_id;
        $this->wilkerName = Wilker::find($this->wilker_id) === null 
                              ? 'UPT :'. Wilker::find(1)->nama_wilker
                              : Wilker::find($this->wilker_id)->nama_wilker;
    	  $this->type 	    = $request->type == 'all' ? $this->all : [$request->type];
        $this->karantina  = strtoupper($request->karantina);
        $this->signatory  = $request->signatory;
    }

    /**
    * Untuk mendapatkan Fullname jenis laporan, 
    * Ex : Dokel => Domestik Keluar
    *
    * @param string $permohonan
    * @return string
    */
    protected function getPermohonanFullName($permohonan)
    {
        return $this->model::getPermohonanFullName($permohonan);
    }

    /**
     * Untuk populasi data yang akan dikirim ke view excel 
     *
     * @param string $permohonanFullName
     * @return array
     */
    protected function datasToView($permohonan)
    {
        return [

          'headers'       => $this->tableHeaderLaporanOperasionalKh(),
          'bodies'        => $this->model::laporanOperasional($this->year, $this->month, $this->wilker_id),
          'permohonan'    => $this->getPermohonanFullName($permohonan),
          'bulan'         => $this->month == 'all' ? '' : Tanggal::bulan($this->month),
          'tahun'         => $this->year,
          'wilker'        => $this->wilkerName,
          'signatory'     => MasterPegawai::with('jabatan')->find($this->signatory),
          'totalPnbp'     => $this->mapTotalPnbp($permohonan),
          'totalVolume'   => $this->mapTotalVolumeKomoditi($permohonan),
          'volumeKomoditi'=> $this->mapRekapitulasiKomoditi($permohonan),

        ];
    }

    /**
     * Untuk populasi total PNBP sesuai jenis permohonan
     *
     * @param string $permohonanFullName
     * @return string
     */
    protected function mapTotalPnbp($permohonan)
    {
        $pnbp = [

          'dokel'       => $this->repository->totalPnbp()->pnbpDokel,
          'domas'       => $this->repository->totalPnbp()->pnbpDomas,
          'ekspor'      => $this->repository->totalPnbp()->pnbpEkspor,
          'impor'       => $this->repository->totalPnbp()->pnbpImpor,
          'serahterima' => $this->repository->totalPnbp()->pnbpSerahTerima,
          'reekspor'    => $this->repository->totalPnbp()->pnbpReekspor,

        ];

        return Rupiah::rp($pnbp[$permohonan]);
    }

    /**
     * Untuk populasi total Volume keseluruhan sesuai jenis permohonan
     *
     * @param string $permohonanFullName
     * @return string
     */
    protected function mapTotalVolumeKomoditi($permohonan)
    {
        return $this->repository->totalVolumePerSatuan()[$permohonan];
    }

    /**
     * Untuk populasi total Volume berdasarkan komoditi sesuai jenis permohonan
     *
     * @param string $permohonanFullName
     * @return string
     */
    protected function mapRekapitulasiKomoditi($permohonan)
    {
        $volume = [

          'dokel'       => $this->repository->totalRekapitulasi()->dokelTotalVolume,
          'domas'       => $this->repository->totalRekapitulasi()->domasTotalVolume,
          'ekspor'      => $this->repository->totalRekapitulasi()->eksporTotalVolume,
          'impor'       => $this->repository->totalRekapitulasi()->imporTotalVolume,
          'serahterima' => $this->repository->totalRekapitulasi()->serahTerimaTotalVolume,
          'reekspor'    => $this->repository->totalRekapitulasi()->reeksporTotalVolume,

        ];

        return $volume[$permohonan];
    }

    /**
     * Format judul laporan
     *
     * @param $sheet
     * @return void
     */
    protected function laporanHeader($sheet)
    {
        $sheet->mergeCells('A1:AK1')->cells('A1:AK1', function($cells) {

            $cells->setFontSize(36);
            $cells->setFontWeight('bold');
            $cells->setFontFamily('Arial');
            
        })->mergeCells('A2:AK2')->cells('A2:AK2', function($cells) {

            $cells->setFontSize(36);
            $cells->setFontWeight('bold');
            $cells->setFontFamily('Arial');
           
        })->mergeCells('A3:AK3')->cells('A3:AK3', function($cells) {

            $cells->setFontSize(36);
            $cells->setFontWeight('bold');
            $cells->setFontFamily('Arial');
           
        })->mergeCells('A4:AK4')->cells('A4:AK4', function($cells) {

            $cells->setFontSize(36);
            $cells->setFontWeight('bold');
            $cells->setFontFamily('Arial');
           
        });

        return $sheet;
    }

    /**
     * Format file excel untuk laporan yang terdapat isi datanya
     *
     * @param $sheet
     * @return void
     */
    protected function sheetFormatting($sheet)
    {
        $this->laporanHeader($sheet);

        /*isi keterangan laporan table*/
        $sheet->setFontSize(12);

        return $sheet;
    }

    /**
     * Format file excel untuk laporan yang tidak punya isi datanya
     *
     * @param $sheet
     * @return void
     */
    protected function nullSheetFormatting($sheet)
    {
        $this->laporanHeader($sheet);

        /*set table body font size*/
        $sheet->cells('A7:AK7', function($cells) {

            $cells->setFontSize(60);
            $cells->setFontWeight('bold');
            $cells->setFontFamily('Arial');
            
        });

        return $sheet;
    }

    /**
     * Format file excel untuk tinggi setiap row
     *
     * @param $sheet
     * @param string $permohonan
     * @return void
     */
    protected function setRowHeight($sheet, $permohonan)
    {
        $countData = count($this->datasToView(strtolower($permohonan))['bodies']);

        /*Jika terdapat data pada laporan*/
        if ($countData > 0) {

          for ($i = 0; $i < $countData; $i++) { 

            $data[$i + $this->startDataRow] = 60;

            $sheet->setHeight($data);

          }

        /*Jika tidak terdapat data pada laporan atau laporan nihil*/  
        } else {

           $sheet->setHeight([7 => 150]);

        }

        return $sheet;
    }

}
