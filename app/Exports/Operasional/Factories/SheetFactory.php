<?php 

namespace App\Exports\Operasional\Factories;

use Illuminate\Support\Str;

class SheetFactory
{
	/**
    * Untuk Menyimpan namespace dari class sheet
    *
    * @var string
    */
	private $namespace = 'App\\Exports\\Operasional\\';

	/**
    * Inisialisasi class sheet yang dibutuhkan sesuai jenis laporan dan karantina
    *
    * @param Illuminate\Http\Request $request
    * @param App\Repositories\Operasional\DataOperasionalKhRepository|DataOperasionalKhRepository $repository
    * @param string $permohonan
    * @throws class not found Exception 
    * @return App\Exports\Operasional\LaporanOperasionalKhPerSheet |
    *		  App\Exports\Operasional\LaporanOperasionalKtPerSheet |
    * 		  App\Exports\Operasional\LaporanRekapitulasiKomoditiKhPerSheet |
    * 		  App\Exports\Operasional\LaporanRekapitulasiKomoditiKtPerSheet |
    */
	public function initSheet($request, $repository, $permohonan)
	{
		$sheetClass = $this->namespace . Str::studly($request->jenisLaporan) . $request->karantina . 'PerSheet';

		if (class_exists($sheetClass)) {

			return new $sheetClass($request, $repository, $permohonan);

		}

		throw new \Exception("Class $sheetClass not found", 1);		
	}
}