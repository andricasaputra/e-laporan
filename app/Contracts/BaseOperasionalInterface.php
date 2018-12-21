<?php

namespace App\Contracts;

use Illuminate\Http\Request;
use App\Http\Requests\UploadOperasionalRequest as Validation;

interface BaseOperasionalInterface
{
	public function tableDetailFrekuensiView(Request $request);

	public function rekapitulasiTableDetail(Request $request);

	public function uploadPageView();

	public function imports(Validation $request);
	
	public function exports();
}
