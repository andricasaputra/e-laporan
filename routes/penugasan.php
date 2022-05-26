<?php

Route::prefix('kt')->group(function(){

	Route::get('/penugasan/menu', 'PenugasanDokelKtController@menu')->name('kt.menu.penugasan.page');

	Route::get('/penugasan/upload', 'PenugasanDokelKtController@home')->name('kt.upload.penugasan.page.home');

	Route::get('/penugasan/dokel/', 'PenugasanDokelKtController@home')->name('kt.upload.penugasan.page.home');

	Route::get('/penugasan/dokel/', 'PenugasanDokelKtController@uploadPage')->name('kt.upload.penugasan.page.dokel');

	Route::get('/penugasan/domas/', 'PenugasanDomasKtController@uploadPage')->name('kt.upload.penugasan.page.domas');

	Route::get('//penugasanekspor/', 'PenugasanEksporKtController@uploadPage')->name('kt.upload.penugasan.page.ekspor');

	Route::get('/penugasan/impor/', 'PenugasanImporKtController@uploadPage')->name('kt.upload.penugasan.page.impor');

	// Upload Proses Laporan
	Route::post('/penugasan/dokel/', 'PenugasanDokelKtController@upload')->name('kt.upload.proses.penugasan.dokel');

	// Lihat Data Penugasan Route
	Route::get(
		'/penugasan/data/home/{year?}/{month?}/{wilker_id?}', 'PenugasanDokelKtController@dataPage'
	)->name('kt.view.penugasan.home');

	// Table data penugasan route
	Route::get(
		'/penugasan/data/table/{year?}/{month?}/{wilker_id?}', 'PenugasanDokelKtController@tableData'
	)->name('api.kt.dokel.penugasan');

});

Route::prefix('kh')->group(function(){

	Route::get('/penugasan/menu', 'PenugasanDokelKhController@menu')->name('kh.menu.penugasan.page');

	Route::get('/penugasan/upload', 'PenugasanDokelKtController@home')->name('kh.upload.penugasan.page.home');

	Route::get('/penugasan/dokel/', 'PenugasanDokelKhController@uploadPage')->name('kh.upload.penugasan.page.dokel');

	Route::get('/penugasan/domas/', 'PenugasanDomasKhController@uploadPage')->name('kh.upload.penugasan.page.domas');

	Route::get('//penugasanekspor/', 'PenugasanEksporKhController@uploadPage')->name('kh.upload.penugasan.page.ekspor');

	Route::get('/penugasan/impor/', 'PenugasanImporKhController@uploadPage')->name('kh.upload.penugasan.page.impor');


});
















