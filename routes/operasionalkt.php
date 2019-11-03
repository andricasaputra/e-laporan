<?php

<<<<<<< HEAD
// "kt/operasional" prefix 

Route::get('menu', 'HomeKtController@showMenu')->name('showmenu.operasional.kt');

// Menu Data Operasional KT
=======
/* kt/operasional prefix */

Route::get(
	'menu', 'HomeKtController@showMenu'
)->name('showmenu.operasional.kt');

/*Menu Data Operasional KT*/
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
Route::get(
	'menu/data', 'HomeKtController@showMenuDataOperasional'
)->name('showmenu.data.operasional.kt');

<<<<<<< HEAD
// Rekapitulasi Page
=======
/*Rekapitulasi Page*/
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
Route::get(
	'data/rekapitulasi/{year?}/{month?}/{wilker_id?}', 'HomeKtController@homeRekapitulasi'
)->name('show.rekapitulasi.operasional.kt');

<<<<<<< HEAD
// Statistik Page
=======
/*Statistik Page*/
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
Route::get(
	'data/statistik/{year?}/{month?}/{wilker_id?}', 'HomeKtController@homeStatistik'
)->name('show.statistik.operasional.kt');

<<<<<<< HEAD
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
=======
/*View Page Rekapitulasi Detail*/
Route::get(
	'data/rekapitulasi/detail/dokel/{year?}/{month?}/{wilker_id?}', 'DokelKtController@rekapitulasiTableDetail'
)->name('kt.view.rekapitulasi.dokel');

Route::get(
	'data/rekapitulasi/detail/domas/{year?}/{month?}/{wilker_id?}', 'DomasKtController@rekapitulasiTableDetail'
)->name('kt.view.rekapitulasi.domas');

Route::get(
	'data/rekapitulasi/detail/ekspor/{year?}/{month?}/{wilker_id?}', 'EksporKtController@rekapitulasiTableDetail'
)->name('kt.view.rekapitulasi.ekspor');

Route::get(
	'data/rekapitulasi/detail/impor/{year?}/{month?}/{wilker_id?}', 'ImporKtController@rekapitulasiTableDetail'
)->name('kt.view.rekapitulasi.impor');

/*View Page Table Detail Frekuensi*/
Route::get(
	'data/statistik/detail/maintable/dokel/{year?}/{month?}/{wilker_id?}', 'DokelKtController@tableDetailFrekuensiView'
)->name('kt.view.page.detail.bigtable.dokel');

Route::get(
	'data/statistik/detail/maintable/domas/{year?}/{month?}/{wilker_id?}', 'DomasKtController@tableDetailFrekuensiView'
)->name('kt.view.page.detail.bigtable.domas');

Route::get(
	'data/statistik/detail/maintable/ekspor/{year?}/{month?}/{wilker_id?}', 'EksporKtController@tableDetailFrekuensiView'
)->name('kt.view.page.detail.bigtable.ekspor');

Route::get(
	'data/statistik/detail/maintable/impor/{year?}/{month?}/{wilker_id?}', 'ImporKtController@tableDetailFrekuensiView'
)->name('kt.view.page.detail.bigtable.impor');

Route::get(
	'data/statistik/detail/maintable/reekspor/{year?}/{month?}/{wilker_id?}', 'ReeksporKtController@tableDetailFrekuensiView'
)->name('kt.view.page.detail.bigtable.reekspor');

Route::get(
	'data/statistik/detail/maintable/serah_terima/{year?}/{month?}/{wilker_id?}', 'SerahTerimaKtController@tableDetailFrekuensiView'
)->name('kt.view.page.detail.bigtable.serah_terima');

/*View Page Table Detail Setor PNBP*/
Route::get(
	'data/statistik/detail/maintable/billing/{year?}/{month?}/{wilker_id?}', 'ReportBillingKtController@tableDetailBillingView'
)->name('kt.view.page.detail.pnbp.setor');

/*View Page Table Detail Pembatalan Dokumen*/
Route::get(
	'data/statistik/detail/dokumen/pembatalan_dokumen/{year?}/{month?}/{wilker_id?}', 'Dokumen\\PembatalanDokKtController@tableDetailPembatalanView'
)->name('kt.view.page.detail.dokumen.pembatalan_dokumen');

/*KT Middleware*/
Route::middleware('kt')->group(function(){

	/*Home Upload View (Domas, Dokel, DLL)*/
	Route::get('upload/home/{tahun?}', 'HomeKtController@homeUpload')
	->name('kt.homeupload');

	/*Home Download View (Domas, Dokel, DLL)*/
	Route::get('download/home', 'HomeKtController@homeDownload')
	->name('kt.homedownload');

	/*Rollback Laporan*/
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
	Route::delete('home/rollback/{id}', 'HomeKtController@destroy')
	->name('rollback.operasional.kt');

	/*
	*-------------------------------------
	* KT Upload Routes
	* ------------------------------------
	*/

<<<<<<< HEAD
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
=======
	Route::get('upload/domas', 'DomasKtController@uploadPageView')
	->name('kt.upload.page.domas');

	Route::get('upload/dokel', 'DokelKtController@uploadPageView')
	->name('kt.upload.page.dokel'); 

	Route::get('upload/ekspor', 'EksporKtController@uploadPageView')
	->name('kt.upload.page.ekspor');

	Route::get('upload/impor', 'ImporKtController@uploadPageView')
	->name('kt.upload.page.impor'); 

	Route::get('upload/pembatalan_dokumen', 'Dokumen\\PembatalanDokKtController@uploadPageView')
	->name('kt.upload.page.pembatalan_dokumen');

	Route::get('upload/reekspor', 'ReeksporKtController@uploadPageView')
	->name('kt.upload.page.reekspor');

	Route::get('upload/serah_terima', 'SerahTerimaKtController@uploadPageView')
	->name('kt.upload.page.serah_terima');

	Route::get('upload/report_billing', 'ReportBillingKtController@uploadPageView')
	->name('kt.upload.page.report_billing');
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41

	/*
	*-------------------------------------
	* KT Proses Upload
	* ------------------------------------
	*/

<<<<<<< HEAD
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
=======
	Route::post('dokel/importdata', 'DokelKtController@imports')
	->name('kt.upload.proses.dokel');

	Route::post('domas/importdata', 'DomasKtController@imports')
	->name('kt.upload.proses.domas');

	Route::post('ekspor/importdata', 'EksporKtController@imports')
	->name('kt.upload.proses.ekspor');

	Route::post('impor/importdata', 'ImporKtController@imports')
	->name('kt.upload.proses.impor');

	Route::post('pembatalan_dokumen/importdata', 'Dokumen\\PembatalanDokKtController@imports')
	->name('kt.upload.proses.pembatalan_dokumen');

	Route::post('reekspor/importdata', 'ReeksporKtController@imports')
	->name('kt.upload.proses.reekspor');

	Route::post('serah_terima/importdata', 'SerahTerimaKtController@imports')
	->name('kt.upload.proses.serah_terima');

	Route::post('report_billing/importdata', 'ReportBillingKtController@imports')
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
	->name('kt.upload.proses.report_billing');

	/*
	*-------------------------------------
	* KT Proses Download
	* ------------------------------------
	*/

<<<<<<< HEAD
	Route::namespace('Download')->prefix('download')->group(function () {

	    Route::post('operasional', 'LaporanOperasionalKtController@laporanOperasionalKt')
		->name('kt.download.operasional');

		Route::post('rekapitulasi', 'LaporanRekapitulasiKomoditiKtController@laporanRekapitulasiKomoditiKt')
		->name('kt.download.rekapitulasi');

		Route::post('pemakaian_dokumen', 'LaporanPemakaianDokumenKtController@laporanPemakaianDokumenKt')
=======
	Route::namespace('Download')->group(function () {

	    Route::post('donwload/operasional', 'LaporanOperasionalKtController@laporanOperasionalKt')
		->name('kt.download.operasional');

		Route::post('donwload/rekapitulasi', 'LaporanRekapitulasiKomoditiKtController@laporanRekapitulasiKomoditiKt')
		->name('kt.download.rekapitulasi');

		Route::post('donwload/pemakaian_dokumen', 'LaporanPemakaianDokumenKtController@laporanPemakaianDokumenKt')
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
		->name('kt.download.pemakaian_dokumen');

	});/*End Download Namespace*/

<<<<<<< HEAD
=======
	

>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
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






