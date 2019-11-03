<?php 

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional\Download;

use Illuminate\Http\Request;
use App\Repositories\Operasional\DataOperasionalKhRepository as Repository;

ini_set('max_execution_time', '500');

class LaporanPemakaianDokumenKhController extends DownloadController
{
    /**
     * Menyimpan start row untuk isi data laporan pada table
     *
     * @var int
     */
    private $startDataRow = 7;

    /**
     * Menyimpan jumlah data laporan
     *
     * @var int
     */
    private $totalData;

    /**
     * Untuk Mendapatkan row tertinggi
     *
     * @var int
     */
    private $higestRow;

    /**
     * Untuk menyimpan total sheet berdasarkan index
     *
     * @var array
     */
    private $sheetIndex = [];

    /**
     * Untuk menyimpan jumlah pemakaian dokumen bulan lalu
     *
     * @var array
     */
    private $penerimaanBulanLalu = [];

    /**
     * Untuk menyimpan jumlah penerimaan dokumen bulan ini
     *
     * @var array
     */
    private $penerimaanBulanIni = [];

    /**
     * Untuk menyimpan total penerimaan dokumen sejak awal tahun
     *
     * @var array
     */
    private $totalPenerimaan = [];

    /**
     * Untuk menyimpan jumlah pemakaian dokumen bulan lalu
     *
     * @var array
     */
    private $pemakaianBulanLalu = [];

    /**
     * Untuk menyimpan jumlah pemakaian dokumen bulan ini
     *
     * @var array
     */
    private $pemakaianBulanIni = [];

    /**
     * Untuk menyimpan total pemakaian dokumen sejak awal tahun
     *
     * @var array
     */
    private $totalPemakaian = [];

    /**
     * Untuk menyimpan total pembatalan dokumen sejak awal tahun
     *
     * @var array
     */
    private $totalPembatalan = [];

    /**
     * Populasi property yang dibutuhkan
     *
     * @return void
     */
<<<<<<< HEAD
  	public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->repository = new Repository($request);
    }
=======
  	public function __construct(Repository $repository, Request $request)
  	{
  		parent::__construct($request);

        $this->repository = new $repository($this->year, $this->month, $this->wilker_id);
  	}
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41

    /**
     * Method utama yang dipanggil untuk export
     *
     * @return Excel
     */
	public function laporanPemakaianDokumenKh()
    {
        return excel()->create("Laporan Pemakaian Dokumen {$this->monthName} Tahun {$this->year} {$this->karantina} {$this->wilkerName}", function($excel) {
                
                $excel->sheet('Pemakaian Dokumen Hewan', function($sheet){

                    /*init page view/ source page laporan*/ 
                    $sheet->loadView('intern.operasional.kh.download.laporan_pemakaian_dokumen_excel')
                          ->with('datas', $this->datasToView());
             
                    $this->sheetFormatting($sheet);

                    /*set global orientation laporan*/
                    $sheet->setOrientation($this->orientation);

                    /*set paper size laporan =  A3*/
                    $sheet->setPaperSize($this->paperSize);

                    /*set global font family*/
                    $sheet->setFontFamily($this->fontFamily);

                    /*set scale dari halaman*/
                    $sheet->setScale($this->scale, true);

                    /*Set width for multiple cells*/ 
                    $sheet->setWidth(array(
                        'A'     =>  5,
                        'B'     =>  15,
                        'C'     =>  15,
                        'D'     =>  15,
                        'E'     =>  15,
                        'F'     =>  15,
                        'G'     =>  15,
                        'H'     =>  15,
                        'I'     =>  15,
                        'J'     =>  15,
                    ));
                    
                });

                /*set wrap text berdasarkan index*/
                $this->setWrapText($excel);

                /*global alignment laporan horizontal center*/
                $excel->getDefaultStyle()
                      ->getAlignment()
                      ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        })->download('xls');
    }

     /**
     * Untuk set semua data dan informasi yang akan dikirim ke view
     *
     * @param string $permohonan
     * @return array
     */
    protected function datasToView()
    {
        return [

            'bodies'     => $this->getData(),
            'bulan'      => $this->getMonth(),
            'tahun'      => $this->year,
            'wilker'     => $this->wilkerName,
            'signatory'  => $this->getSignatory($this->signatory),

        ];
    }

    /**
     * Untuk set data utama pada body table laporan
     *
     * @return array
     */
    protected function setData()
    {
        /*set data penerimaan*/
        $this->penerimaanBulanIni   =   $this->repository->penerimaanDokumen(true)
                                             ->mapWithKeys(function ($item) {
                                                return [
                                                    str_replace('-', '', $item->dokumen->dokumen) => (int) $item['total']
                                                ];
                                            })->sortKeys();

        $this->penerimaanBulanLalu  =   $this->repository->penerimaanDokumenBulanLalu(true)
                                             ->mapWithKeys(function ($item) {
                                                return [
                                                   str_replace('-', '', $item->dokumen->dokumen) => (int) $item['total']
                                                ];
                                            })->sortKeys();

        $this->totalPenerimaan      =   $this->repository->totalPenerimaanDokumen()
                                             ->mapWithKeys(function ($item) {
                                                return [
                                                   str_replace('-', '', $item->dokumen->dokumen) => (int) $item['total']
                                                ];
                                            })->sortKeys();

        /*set data pemakaian*/
        $this->pemakaianBulanIni    =   $this->repository->pemakaianDokumen(true)
                                             ->mapWithKeys(function ($item) {
                                                return [$item['dokumen'] => (int) $item['total']];
                                            })->sortKeys();

        $this->pemakaianBulanLalu   =   $this->repository->pemakaianDokumenBulanLalu(true)
                                             ->mapWithKeys(function ($item) {
                                                return [$item['dokumen'] => (int) $item['total']];
                                            })->sortKeys();

        $this->totalPemakaian       =   $this->repository->totalPemakaianDokumen()
                                             ->mapWithKeys(function ($item) {
                                                return [$item['dokumen'] => (int) $item['total']];
                                            })->sortKeys();

        $this->totalPembatalan      =   $this->repository->pembatalanDokumen()
                                             ->mapWithKeys(function ($item) {
                                                 return [
                                                    $item['dokumen'] => [
                                                        'total' => $item->count(),
                                                        'no_seri' => $item->no_seri
                                                    ],
                                                ];
                                            })->sortKeys();
        return $this;
    }

    /**
     * Untuk set data utama pada body table laporan
     *
     * @return array
     */
    protected function getData()
    {
        /*get data*/
        return [

           'penerimaanbulanIni'  => $this->setData()->penerimaanBulanIni->all(),
           'penerimaanbulanLalu' => $this->setData()->penerimaanBulanLalu->all(),
           'penerimaantotal'     => $this->setData()->totalPenerimaan->all(),
           'pemakaianbulanIni'   => $this->setData()->pemakaianBulanIni->all(),
           'pemakaianbulanLalu'  => $this->setData()->pemakaianBulanLalu->all(),
           'pemakaiantotal'      => $this->setData()->totalPemakaian->all(),
           'pembatalantotal'     => $this->setData()->totalPembatalan->all(),

        ];
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
        $sheet->setFontSize(10);

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
        $sheet->cells('A8:AK8', function($cells) {

            $cells->setFontSize(9);
            $cells->setFontFamily('Arial');
            
        });

        return $sheet;
    }

    /**
     * Format judul laporan
     *
     * @param $sheet
     * @return void
     */
    protected function laporanHeader($sheet)
    {
        $sheet->mergeCells('A1:J1')->cells('A1:J1', function($cells) {

            $cells->setFontSize(12);
            $cells->setFontWeight('bold');
            $cells->setFontFamily('Arial');
            
        })->mergeCells('A2:J2')->cells('A2:J2', function($cells) {

            $cells->setFontSize(12);
            $cells->setFontWeight('bold');
            $cells->setFontFamily('Arial');
           
        })->mergeCells('A3:J3')->cells('A3:J3', function($cells) {

            $cells->setFontSize(12);
            $cells->setFontWeight('bold');
            $cells->setFontFamily('Arial');
           
        })->mergeCells('A4:J4')->cells('A4:J4', function($cells) {

            $cells->setFontSize(12);
            $cells->setFontWeight('bold');
            $cells->setFontFamily('Arial');
           
        })->mergeCells('A5:J5')->cells('A5:J5', function($cells) {

            $cells->setFontSize(12);
            $cells->setFontWeight('bold');
            $cells->setFontFamily('Arial');
           
        });

        return $sheet;
    }

    /**
     * Format file excel agar row menjadi wrap text
     *
     * @param $excel
     * @return void
     */
    protected function setWrapText($excel)
    {
        $this->higestRow = $excel->getActiveSheet()->getHighestRow();

        $row = 'C8:J'.$this->higestRow;

        $excel->getActiveSheet()->getStyle($row)->getAlignment()->setWrapText(true);

        return $excel;
    }

    /**
     * Format file excel untuk tinggi setiap row
     *
     * @param $sheet
     * @return void
     */
    protected function setRowHeight($sheet)
    {
        /*Jika terdapat data pada laporan*/
        if ($this->getCountTotalData() > 0) {

          for ($i = 0; $i < $this->getCountTotalData(); $i++) { 

            $data[$i + $this->startDataRow + 1] = $this->higestRow;

            $sheet->setHeight($data);

          }

        /*Jika tidak terdapat data pada laporan atau laporan nihil*/  
        } else {

           $sheet->setHeight([8 => 150]);

        }

        return $sheet;
    }

    /**
     * Untuk set jumlah data dalam laporan
     *
     * @param int $totalData
     * @return void
     */
    protected function setCountTotalData(int $totalData)
    {
        $this->totalData = $totalData;
    }

    /**
     * Untuk get jumlah data dalam laporan
     *
     * @return int
     */
    protected function getCountTotalData() : int
    {
        return $this->totalData;
    }

}