<?php

/*post for another year choice all routes on tables kh or kt*/
Route::post('viewdata', 'BaseOperasional@selectAnotherYear')
->name('view.select.year');

Route::get('home/{tahun?}/{month?}', 'HomeAdmin@show')
->name('show.operasional');

/*KT Prefix*/
Route::middleware('kt')->prefix('kt')->group(function () {

	Route::get('data_operasional/{tahun?}', 'HomeKt@show')
	->name('show.operasional.kt');

	Route::get('ktoperasional', 'HomeKt@showMenu')
	->name('showmenu.operasional.kt');

	Route::get('home_upload/{tahun?}', 'HomeKt@homeUpload')
	->name('kt.homeupload');

	Route::delete('home/rollback/{id}', 'HomeKt@destroy')
	->name('rollback.operasional.kt');

	/*View Page*/
	Route::get('viewdata/dokel/{tahun?}', 'DokelKt@sendToData')
	->name('kt.view.page.dokel');

	Route::get('viewdata/domas/{tahun?}', 'DomasKt@sendToData')
	->name('kt.view.page.domas');

	Route::get('viewdata/ekspor/{tahun?}', 'EksporKt@sendToData')
	->name('kt.view.page.ekspor');

	Route::get('viewdata/impor/{tahun?}', 'ImporKt@sendToData')
	->name('kt.view.page.impor');

	/*KT Upload Routes*/
	Route::get('upload/domas', 'DomasKt@sendToUpload')
	->name('kt.upload.page.domas');

	Route::get('upload/dokel', 'DokelKt@sendToUpload')
	->name('kt.upload.page.dokel'); 

	Route::get('upload/ekspor', 'EksporKt@sendToUpload')
	->name('kt.upload.page.ekspor');

	Route::get('upload/impor', 'ImporKt@sendToUpload')
	->name('kt.upload.page.impor'); 

	/*Proses Upload*/
	Route::post('dokel/importdata', 'DokelKt@imports')
	->name('kt.upload.proses.dokel');

	Route::post('domas/importdata', 'DomasKt@imports')
	->name('kt.upload.proses.domas');

	Route::post('ekspor/importdata', 'EksporKt@imports')
	->name('kt.upload.proses.ekspor');

	Route::post('impor/importdata', 'ImporKt@imports')
	->name('kt.upload.proses.impor');

	/*Export Routes*/
	/*Route::get('download/domas', function () {
		return view('operasional.kt.download.domas');
	})->name('kt.download.page.domas');

	Route::get('download/dokel', function () {
	    return view('operasional.kt.download.dokel');
	})->name('kt.download.page.dokel'); 

	Route::get('download/ekspor', function () {
	    return view('operasional.kt.download.ekspor');
	})->name('kt.download.page.ekspor'); 

	Route::get('download/impor', function () {
	    return view('operasional.kt.download.impor');
	})->name('kt.download.page.impor'); */

	Route::post('dokel/exportdata/{tahun}/{bulan?}', 'DokelKt@exports')
	->name('kt.download.proses.dokel');

	Route::post('domas/exportdata', 'DomasKt@exports')
	->name('kt.download.proses.domas');

	Route::post('ekspor/exportdata', 'EksporKt@exports')
	->name('kt.download.proses.ekspor');

	Route::post('impor/exportdata', 'ImporKt@exports')
	->name('kt.download.proses.impor');

});

/*KH Prefix*/
Route::middleware('kh')->prefix('kh')->group(function () {

	Route::get('data_operasional/{tahun?}', 'HomeKh@show')
	->name('show.operasional.kh');

	Route::get('khoperasional', 'HomeKh@showMenu')
	->name('showmenu.operasional.kh');

	Route::get('home_upload/{tahun?}/{wilker?}', 'HomeKh@homeUpload')
	->name('kh.homeupload');

	Route::delete('home/rollback/{id}', 'HomeKh@destroy')
	->name('rollback.operasional.kh');

	/*View Page*/
	Route::get('viewdata/dokel/{tahun?}', 'DokelKh@sendToData')
	->name('kh.view.page.dokel');

	Route::get('viewdata/domas/{tahun?}', 'DomasKh@sendToData')
	->name('kh.view.page.domas');

	Route::get('viewdata/ekspor/{tahun?}', 'EksporKh@sendToData')
	->name('kh.view.page.ekspor');

	Route::get('viewdata/impor/{tahun?}', 'ImporKh@sendToData')
	->name('kh.view.page.impor');

	/*KH Upload Routes*/
	Route::get('upload/domas', 'DomasKh@sendToUpload')
	->name('kh.upload.page.domas');

	Route::get('upload/dokel', 'DokelKh@sendToUpload')
	->name('kh.upload.page.dokel'); 

	Route::get('upload/ekspor', 'EksporKh@sendToUpload')
	->name('kh.upload.page.ekspor');

	Route::get('upload/impor', 'ImporKh@sendToUpload')
	->name('kh.upload.page.impor');

	Route::post('dokel/importdata', 'DokelKh@imports')
	->name('kh.upload.proses.dokel');

	Route::post('domas/importdata', 'DomasKh@imports')
	->name('kh.upload.proses.domas');

	Route::post('ekspor/importdata', 'EksporKh@imports')
	->name('kh.upload.proses.ekspor');

	Route::post('impor/importdata', 'ImporKh@imports')
	->name('kh.upload.proses.impor');

	/*Export Routes*/
	/*Route::get('download/domas', function () {
		return view('operasional.kh.download.domas');
	})->name('kh.download.page.domas');

	Route::get('download/dokel', function () {
	    return view('operasional.kh.download.dokel');
	})->name('kh.download.page.dokel'); 

	Route::get('download/ekspor', function () {
	    return view('operasional.kh.download.ekspor');
	})->name('kh.download.page.ekspor'); 

	Route::get('download/impor', function () {
	    return view('operasional.kh.download.impor');
	})->name('kh.download.page.impor'); */

	Route::post('dokel/exportdata/{tahun}/{bulan?}', 'DokelKh@exports')
	->name('kh.download.proses.dokel');

	Route::post('domas/exportdata', 'DomasKh@exports')
	->name('kh.download.proses.domas');

	Route::post('ekspor/exportdata', 'EksporKh@exports')
	->name('kh.download.proses.ekspor');

	Route::post('impor/exportdata', 'ImporKh@exports')
	->name('kh.download.proses.impor');

});




