<?php

/*post for another year choice all routes on tables kh or kt*/
Route::post('viewdata', 'BaseOperasionalController@selectAnotherYear')
->name('view.select.year');

Route::get('home/{tahun?}/{month?}', 'HomeAdminController@show')
->name('show.operasional');

/*KT Prefix*/
Route::middleware('kt')->prefix('kt')->group(function () {

	Route::get('data_operasional/{tahun?}', 'HomeKtController@show')
	->name('show.operasional.kt');

	Route::get('ktoperasional', 'HomeKtController@showMenu')
	->name('showmenu.operasional.kt');

	Route::get('home_upload/{tahun?}', 'HomeKtController@homeUpload')
	->name('kt.homeupload');

	Route::delete('home/rollback/{id}', 'HomeKtController@destroy')
	->name('rollback.operasional.kt');

	/*View Page*/
	Route::get('viewdata/dokel/{tahun?}', 'DokelKtController@sendToData')
	->name('kt.view.page.dokel');

	Route::get('viewdata/domas/{tahun?}', 'DomasKtController@sendToData')
	->name('kt.view.page.domas');

	Route::get('viewdata/ekspor/{tahun?}', 'EksporKtController@sendToData')
	->name('kt.view.page.ekspor');

	Route::get('viewdata/impor/{tahun?}', 'ImporKtController@sendToData')
	->name('kt.view.page.impor');

	/*KT Upload Routes*/
	Route::get('upload/domas', 'DomasKtController@sendToUpload')
	->name('kt.upload.page.domas');

	Route::get('upload/dokel', 'DokelKtController@sendToUpload')
	->name('kt.upload.page.dokel'); 

	Route::get('upload/ekspor', 'EksporKtController@sendToUpload')
	->name('kt.upload.page.ekspor');

	Route::get('upload/impor', 'ImporKtController@sendToUpload')
	->name('kt.upload.page.impor'); 

	/*Proses Upload*/
	Route::post('dokel/importdata', 'DokelKtController@imports')
	->name('kt.upload.proses.dokel');

	Route::post('domas/importdata', 'DomasKtController@imports')
	->name('kt.upload.proses.domas');

	Route::post('ekspor/importdata', 'EksporKtController@imports')
	->name('kt.upload.proses.ekspor');

	Route::post('impor/importdata', 'ImporKtController@imports')
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

	Route::post('dokel/exportdata/{tahun}/{bulan?}', 'DokelKtController@exports')
	->name('kt.download.proses.dokel');

	Route::post('domas/exportdata', 'DomasKtController@exports')
	->name('kt.download.proses.domas');

	Route::post('ekspor/exportdata', 'EksporKtController@exports')
	->name('kt.download.proses.ekspor');

	Route::post('impor/exportdata', 'ImporKtController@exports')
	->name('kt.download.proses.impor');

});

/*KH Prefix*/
Route::middleware('kh')->prefix('kh')->group(function () {

	Route::get('data_operasional/{tahun?}', 'HomeKhController@show')
	->name('show.operasional.kh');

	Route::get('khoperasional', 'HomeKhController@showMenu')
	->name('showmenu.operasional.kh');

	Route::get('home_upload/{tahun?}/{wilker?}', 'HomeKhController@homeUpload')
	->name('kh.homeupload');

	Route::delete('home/rollback/{id}', 'HomeKhController@destroy')
	->name('rollback.operasional.kh');

	/*View Page*/
	Route::get('viewdata/dokel/{tahun?}', 'DokelKhController@sendToData')
	->name('kh.view.page.dokel');

	Route::get('viewdata/domas/{tahun?}', 'DomasKhController@sendToData')
	->name('kh.view.page.domas');

	Route::get('viewdata/ekspor/{tahun?}', 'EksporKhController@sendToData')
	->name('kh.view.page.ekspor');

	Route::get('viewdata/impor/{tahun?}', 'ImporKhController@sendToData')
	->name('kh.view.page.impor');

	/*KH Upload Routes*/
	Route::get('upload/domas', 'DomasKhController@sendToUpload')
	->name('kh.upload.page.domas');

	Route::get('upload/dokel', 'DokelKhController@sendToUpload')
	->name('kh.upload.page.dokel'); 

	Route::get('upload/ekspor', 'EksporKhController@sendToUpload')
	->name('kh.upload.page.ekspor');

	Route::get('upload/impor', 'ImporKhController@sendToUpload')
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

	Route::post('dokel/exportdata/{tahun}/{bulan?}', 'DokelKhController@exports')
	->name('kh.download.proses.dokel');

	Route::post('domas/exportdata', 'DomasKhController@exports')
	->name('kh.download.proses.domas');

	Route::post('ekspor/exportdata', 'EksporKhController@exports')
	->name('kh.download.proses.ekspor');

	Route::post('impor/exportdata', 'ImporKhController@exports')
	->name('kh.download.proses.impor');

});




