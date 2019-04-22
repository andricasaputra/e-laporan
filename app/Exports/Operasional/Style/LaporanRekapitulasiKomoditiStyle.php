<?php 

namespace App\Exports\Operasional\Style;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Sheet;

class LaporanRekapitulasiKomoditiStyle extends AbstractGlobalLaporanStyle
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
	protected $startStyleRow = 7;

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
	 * eventRegister method, cukup memanggil method ini sHa untuk memakai semua style yang diperlukan
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
			['A1:H1', 'A2:H2', 'A3:H3', 'A4:H4', 'A5:H5'],
			[
				'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				],                        
			 'font' => [
					'size' => 24,
					'bold' => true
				]
			]
		);

		$this->eventSheet->getDelegate()->mergeCells('A1:H1');

		$this->eventSheet->getDelegate()->mergeCells('A2:H2');

		$this->eventSheet->getDelegate()->mergeCells('A3:H3');

		$this->eventSheet->getDelegate()->mergeCells('A4:H4');

		$this->eventSheet->getDelegate()->mergeCells('A5:H5');

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
		// ini berguna untuk mengetahui berapa row yang akan terpakai
		// kita mulai menambahkan style pada row setelah judul laporan
		$totalData = ($this->totalData + $this->startStyleRow);

		// Kemudian looping data per row sebanyak isi data laporan dan set font size, border dan aligment isi laporan
		for ($i = $this->startStyleRow; $i <= $totalData; $i++) :

			$this->eventSheet->styleCells(
				'A'.$i.':H'.$i,
				[
					'borders' => [
						'allBorders' => [
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							'color' => ['argb' => '0000'],
						],
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

			($this->totalData === 0) ? $this->eventSheet->setRowHeight($i + 1, 200) : $this->eventSheet->setRowHeight($i + 1, 100);

			$this->eventSheet->setWrapText('A'.$i.':H'.$i, ['wrapText' => true]);

		endfor;

		// set column width untuk isi laporan
		foreach (range('A', 'H') as $abjad) :

			switch ($abjad) {
				case 'A':
					$value = 10; break;
				case 'B':
				case 'C':
				case 'G':
					$value = 40; break;
				case 'H':
					$value = 50; break;
				default:
					$value = 20; break;
			}

			$this->eventSheet->setColumnWidth($abjad, $value);
			
		endforeach;

		// set font size dan aligment untuk nama kolom laporan
		$this->eventSheet->styleCells(
			'A7:H7',
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
		$totalIsiData = ($this->totalData + 7);

		// Disini kita akan looping per row penandatangan laporan untuk dilakukan styling
		for ($i = $totalIsiData + 1; $i <= $totalIsiData + 15; $i++) { 

			$this->eventSheet->styleCells(
				'A'.$i.':H'.$i,
				[
					'alignment' => [
						'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
						'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
					],                        
				 	'font' => [
						'name' => $this->fontName,
						'size' => 18,
						'bold' => true
					]
				]
			);
		}
			
	}
}