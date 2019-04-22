<?php 

namespace App\Exports\Operasional\Factories;

use Illuminate\Support\Str;

class DataFactory
{
	/**
    * Untuk Menyimpan namespace dari class laporan
    *
    * @var string
    */
	private $namespace = 'App\\Exports\\Operasional\\Data\\';

	/**
    * Inisialisasi class data yang dibutuhkan sesuai jenis laporan
    *
    * @param Illuminate\Http\Request $request
    * @param App\Repositories\Operasional\DataOperasionalKhRepository|DataOperasionalKhRepository $repository
    * @param string $permohonan
    * @throws class not found Exception 
    * @return App\Exports\Operasional\Data\LaporanOperasionalData |
    *		  App\Exports\Operasional\Data\LaporanRekapitulasiKomoditiData
    */
	public function initData($request, $repository, $permohonan)
	{
		$dataClass = $this->namespace . Str::studly($request->jenisLaporan) . 'Data';

		if (class_exists($dataClass)) {

			return new $dataClass($request, $repository, $permohonan);

		}

		throw new \Exception("Class $dataClass not found", 1);			
	}
}