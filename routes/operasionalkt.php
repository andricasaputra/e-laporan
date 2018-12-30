<?php

/*KT Prefix*/

Route::get(
	'ktoperasional', 'HomeKtController@showMenu'
)->name('showmenu.operasional.kt');

/*Menu Data Operasional KT*/
Route::get(
	'ktoperasional/menu_operasional', 'HomeKtController@showMenuDataOperasional'
)->name('showmenu.data.operasional.kt');

/*Rekapitulasi Page*/
Route::get(
	'ktoperasional/menu_operasional/rekapitulasi/{year?}/{month?}/{wilker_id?}', 'HomeKtController@homeRekapitulasi'
)->name('show.rekapitulasi.operasional.kt');

/*Statistik Page*/
Route::get(
	'ktoperasional/menu_operasional/statistik/{year?}/{month?}/{wilker_id?}', 'HomeKtController@homeStatistik'
)->name('show.statistik.operasional.kt');

/*View Page Rekapitulasi Detail*/
Route::get(
	'rekapitulasi/dokel/{year?}/{month?}/{wilker_id?}', 'DokelKtController@rekapitulasiTableDetail'
)->name('kt.view.rekapitulasi.dokel');

Route::get(
	'rekapitulasi/domas/{year?}/{month?}/{wilker_id?}', 'DomasKtController@rekapitulasiTableDetail'
)->name('kt.view.rekapitulasi.domas');

Route::get(
	'rekapitulasi/ekspor/{year?}/{month?}/{wilker_id?}', 'EksporKtController@rekapitulasiTableDetail'
)->name('kt.view.rekapitulasi.ekspor');

Route::get(
	'rekapitulasi/impor/{year?}/{month?}/{wilker_id?}', 'ImporKtController@rekapitulasiTableDetail'
)->name('kt.view.rekapitulasi.impor');

/*View Page Table Detail Frekuensi*/
Route::get(
	'statistik/detail/frekuensi/dokel/{year?}/{month?}/{wilker_id?}', 'DokelKtController@tableDetailFrekuensiView'
)->name('kt.view.page.detail.frekuensi.dokel');

Route::get(
	'statistik/detail/frekuensi/domas/{year?}/{month?}/{wilker_id?}', 'DomasKtController@tableDetailFrekuensiView'
)->name('kt.view.page.detail.frekuensi.domas');

Route::get(
	'statistik/detail/frekuensi/ekspor/{year?}/{month?}/{wilker_id?}', 'EksporKtController@tableDetailFrekuensiView'
)->name('kt.view.page.detail.frekuensi.ekspor');

Route::get(
	'statistik/detail/frekuensi/impor/{year?}/{month?}/{wilker_id?}', 'ImporKtController@tableDetailFrekuensiView'
)->name('kt.view.page.detail.frekuensi.impor');

/*View Page Table Detail Pembatalan Dokumen*/
Route::get(
	'statistik/detail/dokumen/pembatalan_dokumen/{year?}/{month?}/{wilker_id?}', 'PembatalanDokKtController@tableDetailPembatalanView'
)->name('kt.view.page.detail.dokumen.pembatalan_dokumen');


Route::middleware('kt')->group(function(){

	Route::get('home_upload/{tahun?}', 'HomeKtController@homeUpload')
	->name('kt.homeupload');

	Route::delete('home/rollback/{id}', 'HomeKtController@destroy')
	->name('rollback.operasional.kt');

	/*KT Upload Routes*/
	Route::get('upload/domas', 'DomasKtController@uploadPageView')
	->name('kt.upload.page.domas');

	Route::get('upload/dokel', 'DokelKtController@uploadPageView')
	->name('kt.upload.page.dokel'); 

	Route::get('upload/ekspor', 'EksporKtController@uploadPageView')
	->name('kt.upload.page.ekspor');

	Route::get('upload/impor', 'ImporKtController@uploadPageView')
	->name('kt.upload.page.impor'); 

	Route::get('upload/pembatalan_dokumen', 'PembatalanDokKtController@uploadPageView')
	->name('kt.upload.page.pembatalan_dokumen');

	/*Proses Upload*/
	Route::post('dokel/importdata', 'DokelKtController@imports')
	->name('kt.upload.proses.dokel');

	Route::post('domas/importdata', 'DomasKtController@imports')
	->name('kt.upload.proses.domas');

	Route::post('ekspor/importdata', 'EksporKtController@imports')
	->name('kt.upload.proses.ekspor');

	Route::post('impor/importdata', 'ImporKtController@imports')
	->name('kt.upload.proses.impor');

	Route::post('pembatalan_dokumen/importdata', 'PembatalanDokKtController@imports')
	->name('kt.upload.proses.pembatalan_dokumen');

	/*Export Routes*/
	// Route::get('download/domas', function () {
	// 	return view('operasional.kt.download.domas');
	// })->name('kt.download.page.domas');

	// Route::get('download/dokel', function () {
	//     return view('operasional.kt.download.dokel');
	// })->name('kt.download.page.dokel'); 

	// Route::get('download/ekspor', function () {
	//     return view('operasional.kt.download.ekspor');
	// })->name('kt.download.page.ekspor'); 

	// Route::get('download/impor', function () {
	//     return view('operasional.kt.download.impor');
	// })->name('kt.download.page.impor'); 

	// Route::post('dokel/exportdata/{tahun}/{bulan?}', 'DokelKtController@exports')
	// ->name('kt.download.proses.dokel');

	// Route::post('domas/exportdata', 'DomasKtController@exports')
	// ->name('kt.download.proses.domas');

	// Route::post('ekspor/exportdata', 'EksporKtController@exports')
	// ->name('kt.download.proses.ekspor');

	// Route::post('impor/exportdata', 'ImporKtController@exports')
	// ->name('kt.download.proses.impor');

});






