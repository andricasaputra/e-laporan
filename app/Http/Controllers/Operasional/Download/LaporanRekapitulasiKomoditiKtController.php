<?php 

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional\Download;

use Illuminate\Http\Request;
use App\Repositories\Operasional\DataOperasionalKtRepository as Repository;

ini_set('max_execution_time', '200');

class LaporanRekapitulasiKomoditiKtController extends DownloadController
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
     * Untuk mentimpan total sheet berdasarkan index
     *
     * @var array
     */
    private $sheetIndex = [];

    /**
     * Populasi property yang dibutuhkan
     *
     * @return void
     */
  	public function __construct(Repository $repository, Request $request)
  	{
  		parent::__construct($request);

        $this->repository = new $repository($this->year, $this->month, $this->wilker_id);
  	}

    /**
     * Method utama yang dipanggil untuk export
     *
     * @return Excel
     */
	public function laporanRekapitulasiKomoditiKt()
    {
        /*set default index*/
        $sheetIndex = 0;

        return excel()->create("Laporan Rekapitulasi Komoditi {$this->monthName} Tahun {$this->year} {$this->karantina} {$this->wilkerName}", function($excel) use (&$sheetIndex) {

            /*Looping sesuai banyak tipe permohonan yang dipilih*/
            foreach ($this->type as $permohonan) :

                /*model yang dipakai sesuai permohonan (domas, dokel, ekspor, impor, reekspor, serahterima)*/
                $this->model = $this->modelNamespace . $permohonan . ucfirst(strtolower($this->karantina));
                
                $excel->sheet($permohonan, function($sheet) use ($permohonan, &$sheetIndex) {

                    /*init page view/ source page laporan*/ 
                    $sheet->loadView('intern.operasional.kt.download.laporan_rekapitulasi_komoditi_excel')
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

                    /*simpan sheet index ke dalam array*/
                    $this->sheetIndex[] += $sheetIndex++;
                    
                });

            endforeach;

            /*set wrap text berdasarkan index*/
            $this->setWrapText($excel, $this->sheetIndex);

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
    protected function datasToView($permohonan)
    {
        return [

            'headers'    => $this->tableHeaderLaporanRekapitulasiKomoditiKt(),
            'bodies'     => $this->setBodyData(),
            'permohonan' => $this->getPermohonanFullName($permohonan),
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
    protected function setBodyData()
    {
        /*get data*/
        $model =  $this->model::laporanRekapitulasiKomoditi($this->year, $this->month, $this->wilker_id);

        /*hitung jumlah data yang ada*/
        $this->setCountTotalData($model->count());

        return  $model->groupBy('wilker_id')->map(function($data){

                    return $data->groupBy('nama_komoditas')->map(function($subdata){
                       
                        return [

                            'wilker'      => $subdata->first()->wilker->nama_wilker,
                            'volume'      => $subdata->sum('volume'), 
                            'frekuensi'   => $subdata->count(),
                            'satuan'      => $subdata->pluck('sat_netto')->flatten(1)->first(),
                            'kota_asal'   => $subdata->groupBy('kota_asal'),
                            'kota_tuju'   => $subdata->groupBy('kota_tuju'),
                            'negara_asal' => $subdata->groupBy('asal'),
                            'negara_tuju' => $subdata->groupBy('tujuan')

                        ];

                    });

                });


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
        $sheet->mergeCells('A1:H1')->cells('A1:H1', function($cells) {

            $cells->setFontSize(14);
            $cells->setFontWeight('bold');
            $cells->setFontFamily('Arial');
            
        })->mergeCells('A2:H2')->cells('A2:H2', function($cells) {

            $cells->setFontSize(14);
            $cells->setFontWeight('bold');
            $cells->setFontFamily('Arial');
           
        })->mergeCells('A3:H3')->cells('A3:H3', function($cells) {

            $cells->setFontSize(14);
            $cells->setFontWeight('bold');
            $cells->setFontFamily('Arial');
           
        })->mergeCells('A4:H4')->cells('A4:H4', function($cells) {

            $cells->setFontSize(14);
            $cells->setFontWeight('bold');
            $cells->setFontFamily('Arial');
           
        })->mergeCells('A5:H5')->cells('A5:H5', function($cells) {

            $cells->setFontSize(14);
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
    protected function setWrapText($excel, array $sheetIndex)
    {
        foreach ($sheetIndex as $key => $value) {

            $excel->setActiveSheetIndex($value);

            $this->higestRow = $excel->getActiveSheet()->getHighestRow();

            $row = 'G8:H'.$this->higestRow;

            $excel->getActiveSheet()->getStyle($row)->getAlignment()->setWrapText(true);

        }

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