<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Operasional;

use Illuminate\Http\Request;

interface BaseOperasionalInterface
{
	public function sendToData(int $year);
	public function sendToUpload();
	public function imports(Request $request);
	public function exports();
}
