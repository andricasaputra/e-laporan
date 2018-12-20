<?php

/*KH Prefix*/

Route::get(
	'khoperasional', 'HomeKhController@showMenu'
)->name('showmenu.operasional.kh');

/*Menu Data Operasional KH*/
Route::get(
	'khoperasional/menu_operasional', 'HomeKhController@showMenuDataOperasional'
)->name('showmenu.data.operasional.kh');

/*Rekapitulasi Page*/
Route::get(
	'khoperasional/menu_operasional/rekapitulasi/{year?}/{month?}/{wilker_id?}', 'HomeKhController@homeRekapitulasi'
)->name('show.rekapitulasi.operasional.kh');

/*Statistik Page*/
Route::get(
	'khoperasional/menu_operasional/statistik/{year?}/{month?}/{wilker_id?}', 'HomeKhController@homeStatistik'
)->name('show.statistik.operasional.kh');

/*View Page Rekapitulasi Detail*/
Route::get(
	'rekapitulasi/dokel/{year?}/{month?}/{wilker_id?}', 'DokelKhController@rekapitulasiTableDetail'
)->name('kh.view.rekapitulasi.dokel');

Route::get(
	'rekapitulasi/domas/{year?}/{month?}/{wilker_id?}', 'DomasKhController@rekapitulasiTableDetail'
)->name('kh.view.rekapitulasi.domas');

Route::get(
	'rekapitulasi/ekspor/{year?}/{month?}/{wilker_id?}', 'EksporKhController@rekapitulasiTableDetail'
)->name('kh.view.rekapitulasi.ekspor');

Route::get(
	'rekapitulasi/impor/{year?}/{month?}/{wilker_id?}', 'ImporKhController@rekapitulasiTableDetail'
)->name('kh.view.rekapitulasi.impor');

/*View Page Table Detail Frekuensi*/
Route::get(
	'statistik/detail/frekuensi/dokel/{year?}/{month?}/{wilker_id?}', 'DokelKhController@tableDetailFrekuensiView'
)->name('kh.view.page.detail.frekuensi.dokel');

Route::get(
	'statistik/detail/frekuensi/domas/{year?}/{month?}/{wilker_id?}', 'DomasKhController@tableDetailFrekuensiView'
)->name('kh.view.page.detail.frekuensi.domas');

Route::get(
	'statistik/detail/frekuensi/ekspor/{year?}/{month?}/{wilker_id?}', 'EksporKhController@tableDetailFrekuensiView'
)->name('kh.view.page.detail.frekuensi.ekspor');

Route::get(
	'statistik/detail/frekuensi/impor/{year?}/{month?}/{wilker_id?}', 'ImporKhController@tableDetailFrekuensiView'
)->name('kh.view.page.detail.frekuensi.impor');

Route::middleware('kh')->group(function(){

	Route::get('home_upload/{year?}', 'HomeKhController@homeUpload')
	->name('kh.homeupload');

	Route::delete('home/rollback/{id}', 'HomeKhController@destroy')
	->name('rollback.operasional.kh');

	/*KH Upload Routes*/
	Route::get('upload/domas', 'DomasKhController@uploadPageView')
	->name('kh.upload.page.domas');

	Route::get('upload/dokel', 'DokelKhController@uploadPageView')
	->name('kh.upload.page.dokel'); 

	Route::get('upload/ekspor', 'EksporKhController@uploadPageView')
	->name('kh.upload.page.ekspor');

	Route::get('upload/impor', 'ImporKhController@uploadPageView')
	->name('kh.upload.page.impor');

	Route::post('dokel/importdata', 'DokelKhController@imports')
	->name('kh.upload.proses.dokel');

	Route::post('domas/importdata', 'DomasKhController@imports')
	->name('kh.upload.proses.domas');

	Route::post('ekspor/importdata', 'EksporKhController@imports')
	->name('kh.upload.proses.ekspor');

	Route::post('impor/importdata', 'ImporKhController@imports')
	->name('kh.upload.proses.impor');

	/*Export Routes*/
	// Route::get('download/domas', function () {
	// 	return view('operasional.kh.download.domas');
	// })->name('kh.download.page.domas');

	// Route::get('download/dokel', function () {
	//     return view('operasional.kh.download.dokel');
	// })->name('kh.download.page.dokel'); 

	// Route::get('download/ekspor', function () {
	//     return view('operasional.kh.download.ekspor');
	// })->name('kh.download.page.ekspor'); 

	// Route::get('download/impor', function () {
	//     return view('operasional.kh.download.impor');
	// })->name('kh.download.page.impor'); 

	// Route::post('dokel/exportdata/{year}/{bulan?}', 'DokelKhController@exports')
	// ->name('kh.download.proses.dokel');

	// Route::post('domas/exportdata', 'DomasKhController@exports')
	// ->name('kh.download.proses.domas');

	// Route::post('ekspor/exportdata', 'EksporKhController@exports')
	// ->name('kh.download.proses.ekspor');

	// Route::post('impor/exportdata', 'ImporKhController@exports')
	// ->name('kh.download.proses.impor');


});




