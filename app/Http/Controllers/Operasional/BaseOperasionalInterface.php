<?php

namespace App\Http\Controllers\Operasional;

use Illuminate\Http\Request;

interface BaseOperasionalInterface
{
	public function sendToData($year);
	public function sendToUpload();
	public function imports(Request $request);
	public function exports();
}
