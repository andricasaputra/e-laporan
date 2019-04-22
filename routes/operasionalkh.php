<?php

// "kh/operasional" prefix 

Route::get('menu', 'HomeKhController@showMenu')->name('showmenu.operasional.kh');

// Menu Data Operasional KH
Route::get(
	'menu/data', 'HomeKhController@showMenuDataOperasional'
)->name('showmenu.data.operasional.kh');

// Rekapitulasi Page
Route::get(
	'data/rekapitulasi/{year?}/{month?}/{wilker_id?}', 'HomeKhController@homeRekapitulasi'
)->name('show.rekapitulasi.operasional.kh');

// Statistik Page
Route::get(
	'data/statistik/{year?}/{month?}/{wilker_id?}', 'HomeKhController@homeStatistik'
)->name('show.statistik.operasional.kh');

// View Page Rekapitulasi Detail
Route::prefix('data/rekapitulasi/detail/')->group(function(){

	Route::get(
		'dokel/{year?}/{month?}/{wilker_id?}', 'DokelKhController@rekapitulasiPage'
	)->name('kh.view.rekapitulasi.dokel');

	Route::get(
		'domas/{year?}/{month?}/{wilker_id?}', 'DomasKhController@rekapitulasiPage'
	)->name('kh.view.rekapitulasi.domas');

	Route::get(
		'ekspor/{year?}/{month?}/{wilker_id?}', 'EksporKhController@rekapitulasiPage'
	)->name('kh.view.rekapitulasi.ekspor');

	Route::get(
		'impor/{year?}/{month?}/{wilker_id?}', 'ImporKhController@rekapitulasiPage'
	)->name('kh.view.rekapitulasi.impor');

});

// View Page Table Detail Frekuensi
Route::prefix('data/statistik/detail/maintable/')->group(function(){

	Route::get(
		'dokel/{year?}/{month?}/{wilker_id?}', 'DokelKhController@tableDetailPage'
	)->name('kh.view.page.detail.bigtable.dokel');

	Route::get(
		'domas/{year?}/{month?}/{wilker_id?}', 'DomasKhController@tableDetailPage'
	)->name('kh.view.page.detail.bigtable.domas');

	Route::get(
		'ekspor/{year?}/{month?}/{wilker_id?}', 'EksporKhController@tableDetailPage'
	)->name('kh.view.page.detail.bigtable.ekspor');

	Route::get(
		'impor/{year?}/{month?}/{wilker_id?}', 'ImporKhController@tableDetailPage'
	)->name('kh.view.page.detail.bigtable.impor');

	Route::get(
		'reekspor/{year?}/{month?}/{wilker_id?}', 'ReeksporKhController@tableDetailPage'
	)->name('kh.view.page.detail.bigtable.reekspor');

	Route::get(
		'serah_terima/{year?}/{month?}/{wilker_id?}', 'SerahTerimaKhController@tableDetailPage'
	)->name('kh.view.page.detail.bigtable.serah_terima');

	// View Page Table Detail Setor PNBP
	Route::get(
		'billing/{year?}/{month?}/{wilker_id?}', 'ReportBillingKhController@tableDetailPage'
	)->name('kh.view.page.detail.pnbp.setor');

	// View Page Table Detail Pembatalan Dokumen
	Route::get(
		'dokumen/pembatalan_dokumen/{year?}/{month?}/{wilker_id?}', 'Dokumen\\PembatalanDokKhController@tableDetailPage'
	)->name('kh.view.page.detail.dokumen.pembatalan_dokumen');

});

// KH Middleware
Route::middleware('kh')->group(function(){

	// Home Upload Page (Domas, Dokel, DLL)
	Route::get('upload/home/{tahun?}', 'HomeKhController@homeUpload')
	->name('kh.homeupload');

	// Home Download Page (Domas, Dokel, DLL)
	Route::get('download/home', 'HomeKhController@homeDownload')
	->name('kh.homedownload');

	// Rollback Laporan
	Route::delete('home/rollback/{id}', 'HomeKhController@destroy')
	->name('rollback.operasional.kh');

	/*
	*-------------------------------------
	* KH Upload Routes
	* ------------------------------------
	*/

	Route::prefix('upload')->group(function(){

		Route::get('domas', 'DomasKhController@uploadPage')
		->name('kh.upload.page.domas');

		Route::get('dokel', 'DokelKhController@uploadPage')
		->name('kh.upload.page.dokel'); 

		Route::get('ekspor', 'EksporKhController@uploadPage')
		->name('kh.upload.page.ekspor');

		Route::get('impor', 'ImporKhController@uploadPage')
		->name('kh.upload.page.impor'); 

		Route::get('pembatalan_dokumen', 'Dokumen\\PembatalanDokKhController@uploadPage')
		->name('kh.upload.page.pembatalan_dokumen');

		Route::get('reekspor', 'ReeksporKhController@uploadPage')
		->name('kh.upload.page.reekspor');

		Route::get('serah_terima', 'SerahTerimaKhController@uploadPage')
		->name('kh.upload.page.serah_terima');

		Route::get('report_billing', 'ReportBillingKhController@uploadPage')
		->name('kh.upload.page.report_billing');

	});

	/*
	*-------------------------------------
	* Kh Proses Upload
	* ------------------------------------
	*/

	Route::post('dokel', 'DokelKhController@imports')
	->name('kh.upload.proses.dokel');

	Route::post('domas', 'DomasKhController@imports')
	->name('kh.upload.proses.domas');

	Route::post('ekspor', 'EksporKhController@imports')
	->name('kh.upload.proses.ekspor');

	Route::post('impor', 'ImporKhController@imports')
	->name('kh.upload.proses.impor');

	Route::post('pembatalan_dokumen', 'Dokumen\\PembatalanDokKhController@imports')
	->name('kh.upload.proses.pembatalan_dokumen');

	Route::post('reekspor', 'ReeksporKhController@imports')
	->name('kh.upload.proses.reekspor');

	Route::post('serah_terima', 'SerahTerimaKhController@imports')
	->name('kh.upload.proses.serah_terima');

	Route::post('report_billing', 'ReportBillingKhController@imports')
	->name('kh.upload.proses.report_billing');

	/*
	*-------------------------------------
	* KH Proses Download
	* ------------------------------------
	*/

	Route::namespace('Download')->prefix('download')->group(function () {

	    Route::post('operasional', 'LaporanOperasionalController@laporanOperasionalKh')
		->name('kh.download.operasional');

		Route::post('rekapitulasi', 'LaporanRekpitulasiKomoditiController@laporanRekapitulasiKomoditiKh')
		->name('kh.download.rekapitulasi');

		Route::post('pemakaian_dokumen', 'LaporanPemakaianDokumenKhController@laporanPemakaianDokumenKh')
		->name('kh.download.pemakaian_dokumen');

	});/*End Download Namespace*/

});/*End Middleware KH*/

/*
*-------------------------------------
* KH Dokumen
* ------------------------------------
*/

Route::namespace('Dokumen')->prefix('dokumen')->group(function () {

	Route::get('home/{year?}/{month?}/{wilkerId?}', 'DokumenController@indexKh')->name('kh.dokumen.index');

	Route::get('data/{year?}/{month?}/{wilkerId?}', 'DokumenController@dataDokumenKh')
		->name('kh.dokumen.data');

	Route::middleware('kh')->group(function(){

		Route::resource('penerimaan', 'PenerimaanDokumenKhController', [
	    	'names' => 'kh.dokumen.penerimaan'
		])->except(['index', 'show', 'destroy']);

	});/*End KH Middleware*/

});/*End Dokumen Namespace*/






