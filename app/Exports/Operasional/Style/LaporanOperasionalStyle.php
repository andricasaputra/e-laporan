<?php 

namespace App\Exports\Operasional\Style;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Sheet;

class LaporanOperasionalStyle extends AbstractGlobalLaporanStyle
{
	/**
	* Untuk menyimpan instance dari Maatwebsite\Excel\Sheet
	*
	* @var Maatwebsite\Excel\Sheet
	*/
 	public $eventSheet;

	/**
	* Untuk menyimpan total data isi laporan
	*
	* @var int
	*/
	public $totalData;

	/**
	* Untuk menyimpan total data dari rekapitulasi komoditas
	* yang akan dipakai pada bagian keterangan laporan operasional
	*
	* @var int
	*/
	public $totalKetData;

	/**
	* Untuk menyimpan awal row yang akan diberikan style
	*
	* @var int
	*/
	protected $startStyleRow = 6;

	/**
    * Set property awal
    *
    * @param Illuminate\Http\Request $request
    * @param Maatwebsite\Excel\Sheet $sheet
    * @param int $totalData
    * @param int $totalKetData
    * @return void
    */
	public function __construct(Request $request, Sheet $eventSheet, int $totalData, ?int $totalKetData)
	{
		parent::__construct($request);

		$this->eventSheet 	= $eventSheet;

		$this->totalData 	= $totalData;

		$this->totalKetData = $totalKetData;
	}

	/**
	 * Method utama yang akan dipanggil untuk inisialisasi style yang akan dipakai
	 * pada laporan excel, disini terdapat semua method kumpulan style, sehingga pada bagian
	 * eventRegister method, cukup memanggil method ini saja untuk memakai semua style yang diperlukan
	 *
	 * @return void
	 */
	public function applyStyle()
	{
		// Set Orientasi Kertas
		$this->eventSheet->getPageSetup()->setOrientation($this->orientation);

		// Set Ukuran Kertas
		$this->eventSheet->getPageSetup()->setPaperSize($this->paperSize);

		// Set Skala Kertas untuk kebutuhan print
		$this->eventSheet->getPageSetup()->setScale($this->scale);  

		// Set Header Laporan (merge cells dan font style) pada 5 row awal
		$this->setLaporanHeader();

		// Set style dari isi laporan (bordering, set row height, font sizing)
		$this->setLaporanIsi();

		// Set style dari keterangan dan penandatangan laporan (font sizing)
		$this->setLaporanFooter();
	}

	/**
	* Format judul laporan
	*
	* @return Maatwebsite\Excel\Sheet
	*/
	public function setLaporanHeader()
	{
		// Set style untuk judul laporan dan kemudian merge
		$this->eventSheet->styleCells(
			['A1:AJ1', 'A2:AJ2', 'A3:AJ3', 'A4:AJ4'],
			[
				'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				],                        
			 'font' => [
					'size' => 36,
					'bold' => true
				]
			]
		);

		$this->eventSheet->getDelegate()->mergeCells('A1:AJ1');

		$this->eventSheet->getDelegate()->mergeCells('A2:AJ2');

		$this->eventSheet->getDelegate()->mergeCells('A3:AJ3');

		$this->eventSheet->getDelegate()->mergeCells('A4:AJ4');

		return $this->eventSheet;
	}

	/**
	 * Format style dari isi laporan
	 *
	 * @return void
	 */
	public function setLaporanIsi()
	{
		// Pertama kita akan menghitung jumlah isi data dari laporan
		// ini berguna untuk mengetahui berapa row yang akan terpakai untuk data laporan
		$totalData = ($this->totalData + $this->startStyleRow);

		// Jika laporan ternyata nihil maka totalData kita akan tambah 1 agar row
		// kedua pada laporan yang nihil tetap diberikan style border, font size dsb
		$totalData = $this->totalData === 0 ? $totalData + 1: $totalData;

		// Kemudian looping data per row sebanyak isi data laporan dan set font size, border dan aligment isi laporan
		for ($i = $this->startStyleRow; $i <= $totalData; $i++) :

			$this->eventSheet->styleCells(
				'A'.$i.':AJ'.$i,
				[
					'borders' => [
						'allBorders' => [
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							'color' => ['argb' => '0000'],
						]
					],
					'alignment' => [
						'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
						'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
					],                        
				 	'font' => [
						'name' => $this->fontName,
						'size' => 12
					]
				]
			);  

			$this->eventSheet->setRowHeight($i + 1, 60);

		endfor;

		// Set font size dan aligment nama kolom laporan
		$this->eventSheet->styleCells(
			'A6:AJ6',
			[
				'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
					'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
				],                        
			 	'font' => [
					'name' => $this->fontName,
					'size' => 12,
					'bold' => true
				]
			]
		);
	}

	/**
	 * Format style dariS keterangan komoditas dan penandatangan laporan
	 *
	 * @return void
	 */
	public function setLaporanFooter()
	{
		// Pertama kita akan menghitung jumlah isi data dari laporan
		// ini berguna untuk mengetahui berapa row yang akan terpakai untuk data laporan
		$totalIsiData = ($this->totalData + $this->startStyleRow);

		// Kemudian kita tambah +10 untuk mengambil 10 row awal setelah isi data laporan
		// karna isi keterangan tidak langsung berada setelah isi data laporan, 10 row juga berguna
		// sebagai spasi agar laporan terlihat lebih rapi, kemudian kita hitung juga jumlah data keterangan 
		// dari method mapRekapitulasiKomoditi, ini untuk mengetahui berapa row selanjutnya yang akan digunakan 
		// untuk menampilkan data keterangan komoditi pada laporan dan kita berikan style sebanyak jumlah komoditinya
		$totalKetData = (10 + $this->totalKetData);

		// Kemudian disini kita jumlahkan untuk mendapatkan total keseluruhan row yang dibutuhkan
		$total = $totalIsiData + $totalKetData;

		// Disini kita akan looping per row rekapitulasi komoditi untuk dilakukan styling
		for ($i = $totalIsiData + 1; $i <= $total; $i++) { 

			// Set font size apabila laporan nihil gunakan font size 40pt
			$fontSize = $i === 7 ? 40 : 16;

			$this->eventSheet->styleCells(
				'A'.$i.':AJ'.$i,
				[
					'alignment' => [
						'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
						'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
					],                        
				 	'font' => [
						'name' => $this->fontName,
						'size' => $fontSize,
						'bold' => true
					]
				]
			);
		}

		// Terakhir kita akan looping per row penandatangan laporan untuk dilakukan styling
		for ($i = $total + 1; $i <= $total + 11; $i++) { 

			$this->eventSheet->styleCells(
				'A'.$i.':AJ'.$i,
				[
					'alignment' => [
						'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
						'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
					],                        
				 	'font' => [
						'name' => $this->fontName,
						'size' => 32,
						'bold' => true
					]
				]
			);
		}
			
	}
}