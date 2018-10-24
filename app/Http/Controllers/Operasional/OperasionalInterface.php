<?php  

namespace App\Http\Controllers\Operasional;

use Illuminate\Http\Request;

interface OperasionalInterface 
{
	public function checkUserWilker($path);
	public function checkJenisKarantina($path);
	public function checkJenisPermohonan($path);
	public function imports(Request $request);
	public function exports(Request $request);
}