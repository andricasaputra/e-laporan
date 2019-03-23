<?php

namespace App\Contracts\Operasional;

use Illuminate\Http\Request;
use App\Http\Requests\UploadOperasionalRequest as Validation;

interface BaseOperasionalInterface
{
	/**
     * Untuk Halaman Detail Laporan 
     *
     * @param Illuminate\Http\Request $request
     * @return void
     */
	public function tableDetailPage(Request $request);

	/**
     * Untuk Halaman Rekapitulasi Laporan 
     *
     * @param Illuminate\Http\Request $request
     * @return void
     */
	public function rekapitulasiPage(Request $request);

	/**
     * Untuk Halaman Upload Laporan 
     *
     * @param Illuminate\Http\Request $request
     * @return void
     */
	public function uploadPage(Request $request);

	/**
     * Import data laporan excel ke dalam database 
     *
     * @param App\Http\Requests\UploadOperasionalRequest $request
     * @return void
     */
	public function imports(Validation $request);
}
