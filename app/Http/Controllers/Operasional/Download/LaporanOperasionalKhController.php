<?php 

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional\Download;

use Illuminate\Http\Request;
use App\Repositories\Operasional\DataOperasionalKhRepository as Repository;

ini_set('max_execution_time', '500');

class LaporanOperasionalKhController extends DownloadController
{
    /**
     * Menyimpan start row untuk isi data laporan pada table
     *
     * @var int
     */
    private $startDataRow = 7;

    /**
     * Populasi property yang dibutuhkan
     *
     * @return void
     */
  	public function __construct(Request $request)
  	{
  		parent::__construct($request);

        $this->repository = new Repository($request);
  	}

    /**
     * Method utama yang dipanggil untuk export
     *
     * @return Excel
     */
	public function laporanOperasionalKh()
    {
        return excel()->create("Laporan Operasional {$this->monthName} Tahun {$this->year} {$this->karantina} {$this->wilkerName}", function($excel) {

            /*Looping sesuai banyak tipe permohonan yang dipilih*/
            foreach ($this->type as $permohonan) :

                /*model yang dipakai sesuai permohonan (domas, dokel, ekspor, impor, reekspor, serahterima)*/
                $this->model = $this->modelNamespace . $permohonan . ucfirst(strtolower($this->karantina));
                
                $excel->sheet($permohonan, function($sheet) use ($permohonan) {

                    /*init page view/ source page laporan*/
                    $sheet->loadView('intern.operasional.kh.download.laporan_operasional_excel')
                          ->with('datas', $this->datasToView(strtolower($permohonan)));
                  
                    /*jika data null atau nihil*/
                    if (count($this->datasToView(strtolower($permohonan))['bodies']) === 0) {

                      $this->nullSheetFormatting($sheet);

                    /*jika data tidak nihil*/
                    } else {

                      $this->sheetFormatting($sheet);

                    }

                    /*set global orientation laporan*/
                    $sheet->setOrientation($this->orientation);

                    /*set paper size laporan =  A3*/
                    $sheet->setPaperSize($this->paperSize);

                    /*set global font family*/
                    $sheet->setFontFamily($this->fontFamily);

                    /*set scale dari halaman*/
                    $sheet->setScale($this->scale, true);

                    /*set rowheight hanya untuk data di dalam table*/
                    $this->setRowHeight($sheet, $permohonan);
    
                });

            endforeach;

            /*global alignment laporan horizontal center*/
            $excel->getDefaultStyle()
                  ->getAlignment()
                  ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        })->download('xls');
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
          'bodies'        => $this->model::laporanOperasional([$this->year, $this->month, $this->wilker_id]),
          'permohonan'    => $this->getPermohonanFullName($permohonan),
          'bulan'         => $this->getMonth(),
          'tahun'         => $this->year,
          'wilker'        => $this->wilkerName,
          'signatory'     => $this->getSignatory($this->signatory),
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

        return rp($pnbp[$permohonan]);
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
        $sheet->mergeCells('A1:AJ1')->cells('A1:AJ1', function($cells) {

            $cells->setFontSize(36);
            $cells->setFontWeight('bold');
            $cells->setFontFamily('Arial');
            
        })->mergeCells('A2:AJ2')->cells('A2:AJ2', function($cells) {

            $cells->setFontSize(36);
            $cells->setFontWeight('bold');
            $cells->setFontFamily('Arial');
           
        })->mergeCells('A3:AJ3')->cells('A3:AJ3', function($cells) {

            $cells->setFontSize(36);
            $cells->setFontWeight('bold');
            $cells->setFontFamily('Arial');
           
        })->mergeCells('A4:AJ4')->cells('A4:AJ4', function($cells) {

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
        $sheet->cells('A7:AJ7', function($cells) {

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
    protected function setRowHeight($sheet, $permohonan, $height = 60)
    {
        $countData = count($this->datasToView(strtolower($permohonan))['bodies']);

        /*Jika terdapat data pada laporan*/
        if ($countData > 0) {

          for ($i = 0; $i < $countData; $i++) { 

            $data[$i + $this->startDataRow] = $height;

            $sheet->setHeight($data);

          }

        /*Jika tidak terdapat data pada laporan atau laporan nihil*/  
        } else {

           $sheet->setHeight([7 => 150]);

        }

        return $sheet;
    }

}