<?php

// "kt/operasional" prefix 

Route::get('menu', 'HomeKtController@showMenu')->name('showmenu.operasional.kt');

// Menu Data Operasional KT
Route::get(
	'menu/data', 'HomeKtController@showMenuDataOperasional'
)->name('showmenu.data.operasional.kt');

// Rekapitulasi Page
Route::get(
	'data/rekapitulasi/{year?}/{month?}/{wilker_id?}', 'HomeKtController@homeRekapitulasi'
)->name('show.rekapitulasi.operasional.kt');

// Statistik Page
Route::get(
	'data/statistik/{year?}/{month?}/{wilker_id?}', 'HomeKtController@homeStatistik'
)->name('show.statistik.operasional.kt');

// View Page Rekapitulasi Detail
Route::prefix('data/rekapitulasi/detail/')->group(function(){

	Route::get(
		'dokel/{year?}/{month?}/{wilker_id?}', 'DokelKtController@rekapitulasiPage'
	)->name('kt.view.rekapitulasi.dokel');

	Route::get(
		'domas/{year?}/{month?}/{wilker_id?}', 'DomasKtController@rekapitulasiPage'
	)->name('kt.view.rekapitulasi.domas');

	Route::get(
		'ekspor/{year?}/{month?}/{wilker_id?}', 'EksporKtController@rekapitulasiPage'
	)->name('kt.view.rekapitulasi.ekspor');

	Route::get(
		'impor/{year?}/{month?}/{wilker_id?}', 'ImporKtController@rekapitulasiPage'
	)->name('kt.view.rekapitulasi.impor');

});

// View Page Table Detail Frekuensi
Route::prefix('data/statistik/detail/maintable/')->group(function(){

	Route::get(
		'dokel/{year?}/{month?}/{wilker_id?}', 'DokelKtController@tableDetailPage'
	)->name('kt.view.page.detail.bigtable.dokel');

	Route::get(
		'domas/{year?}/{month?}/{wilker_id?}', 'DomasKtController@tableDetailPage'
	)->name('kt.view.page.detail.bigtable.domas');

	Route::get(
		'ekspor/{year?}/{month?}/{wilker_id?}', 'EksporKtController@tableDetailPage'
	)->name('kt.view.page.detail.bigtable.ekspor');

	Route::get(
		'impor/{year?}/{month?}/{wilker_id?}', 'ImporKtController@tableDetailPage'
	)->name('kt.view.page.detail.bigtable.impor');

	Route::get(
		'reekspor/{year?}/{month?}/{wilker_id?}', 'ReeksporKtController@tableDetailPage'
	)->name('kt.view.page.detail.bigtable.reekspor');

	Route::get(
		'serah_terima/{year?}/{month?}/{wilker_id?}', 'SerahTerimaKtController@tableDetailPage'
	)->name('kt.view.page.detail.bigtable.serah_terima');

	// View Page Table Detail Setor PNBP
	Route::get(
		'billing/{year?}/{month?}/{wilker_id?}', 'ReportBillingKtController@tableDetailPage'
	)->name('kt.view.page.detail.pnbp.setor');

	// View Page Table Detail Pembatalan Dokumen
	Route::get(
		'dokumen/pembatalan_dokumen/{year?}/{month?}/{wilker_id?}', 'Dokumen\\PembatalanDokKtController@tableDetailPage'
	)->name('kt.view.page.detail.dokumen.pembatalan_dokumen');

});

// KT Middleware
Route::middleware('kt')->group(function(){

	// Home Upload Page (Domas, Dokel, DLL)
	Route::get('upload/home/{tahun?}', 'HomeKtController@homeUpload')
	->name('kt.homeupload');

	// Home Download Page (Domas, Dokel, DLL)
	Route::get('download/home', 'HomeKtController@homeDownload')
	->name('kt.homedownload');

	// Rollback Laporan
	Route::delete('home/rollback/{id}', 'HomeKtController@destroy')
	->name('rollback.operasional.kt');

	/*
	*-------------------------------------
	* KT Upload Routes
	* ------------------------------------
	*/

	Route::prefix('upload')->group(function(){

		Route::get('domas', 'DomasKtController@uploadPage')
		->name('kt.upload.page.domas');

		Route::get('dokel', 'DokelKtController@uploadPage')
		->name('kt.upload.page.dokel'); 

		Route::get('ekspor', 'EksporKtController@uploadPage')
		->name('kt.upload.page.ekspor');

		Route::get('impor', 'ImporKtController@uploadPage')
		->name('kt.upload.page.impor'); 

		Route::get('pembatalan_dokumen', 'Dokumen\\PembatalanDokKtController@uploadPage')
		->name('kt.upload.page.pembatalan_dokumen');

		Route::get('reekspor', 'ReeksporKtController@uploadPage')
		->name('kt.upload.page.reekspor');

		Route::get('serah_terima', 'SerahTerimaKtController@uploadPage')
		->name('kt.upload.page.serah_terima');

		Route::get('report_billing', 'ReportBillingKtController@uploadPage')
		->name('kt.upload.page.report_billing');

	});

	/*
	*-------------------------------------
	* KT Proses Upload
	* ------------------------------------
	*/

	Route::post('dokel', 'DokelKtController@imports')
	->name('kt.upload.proses.dokel');

	Route::post('domas', 'DomasKtController@imports')
	->name('kt.upload.proses.domas');

	Route::post('ekspor', 'EksporKtController@imports')
	->name('kt.upload.proses.ekspor');

	Route::post('impor', 'ImporKtController@imports')
	->name('kt.upload.proses.impor');

	Route::post('pembatalan_dokumen', 'Dokumen\\PembatalanDokKtController@imports')
	->name('kt.upload.proses.pembatalan_dokumen');

	Route::post('reekspor', 'ReeksporKtController@imports')
	->name('kt.upload.proses.reekspor');

	Route::post('serah_terima', 'SerahTerimaKtController@imports')
	->name('kt.upload.proses.serah_terima');

	Route::post('report_billing', 'ReportBillingKtController@imports')
	->name('kt.upload.proses.report_billing');

	/*
	*-------------------------------------
	* KT Proses Download
	* ------------------------------------
	*/

	Route::namespace('Download')->prefix('download')->group(function () {

	    Route::post('operasional', 'LaporanOperasionalController@laporanOperasionalKt')
		->name('kt.download.operasional');

		Route::post('rekapitulasi', 'LaporanRekpitulasiKomoditiController@laporanRekapitulasiKomoditiKt')
		->name('kt.download.rekapitulasi');

		Route::post('pemakaian_dokumen', 'LaporanPemakaianDokumenKtController@laporanPemakaianDokumenKt')
		->name('kt.download.pemakaian_dokumen');

	});/*End Download Namespace*/

});/*End Middleware KT*/

/*
*-------------------------------------
* KT Dokumen
* ------------------------------------
*/

Route::namespace('Dokumen')->prefix('dokumen')->group(function () {

	Route::get('home/{year?}/{month?}/{wilkerId?}', 'DokumenController@indexKt')->name('kt.dokumen.index');

	Route::get('data/{year?}/{month?}/{wilkerId?}', 'DokumenController@dataDokumenKt')
		->name('kt.dokumen.data');

	Route::middleware('kt')->group(function(){

		Route::resource('penerimaan', 'PenerimaanDokumenKtController', [
	    	'names' => 'kt.dokumen.penerimaan'
		])->except(['index', 'show', 'destroy']);

	});/*End KT Middleware*/

});/*End Dokumen Namespace*/






