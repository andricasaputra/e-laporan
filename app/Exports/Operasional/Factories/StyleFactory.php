<?php 

namespace App\Exports\Operasional\Factories;

use Illuminate\Support\Str;

class StyleFactory
{
	/**
    * Untuk Menyimpan namespace dari class style
    *
    * @var string
    */
	private $namespace = 'App\\Exports\\Operasional\\Style\\';

	/**
    * Inisialisasi class style yang dibutuhkan sesuai jenis laporan
    *
    * @param Illuminate\Http\Request $request
    * @param Maatwebsite\Excel\Sheet $eventSheet
    * @param int $totalData
    * @param int $totalKetData
    * @throws class not found Exception 
    * @return App\Exports\Operasional\Style\LaporanOperasionalStyle |
    *		  App\Exports\Operasional\Style\LaporanRekapitulasiKomoditiStyle
    */
	public function initStyle($request, $eventSheet, $totalData, $totalKetData)
	{
		$styleClass = $this->namespace . Str::studly($request->jenisLaporan) . 'Style';

		if (class_exists($styleClass)) {

			return new $styleClass($request, $eventSheet, $totalData, $totalKetData);

		}

		throw new \Exception("Class $styleClass not found", 1);		
	}
}