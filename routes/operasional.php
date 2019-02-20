<?php

Route::get('home/{year?}/{month?}/{wilker_id?}', 'HomeController@show')
->name('show.operasional');

/*route halaman info update aplikasi untuk user*/
Route::get('pengumuman/info', 'Admin\\PengumumanController@info')->name('page.info');

/*routes untuk admin*/
Route::namespace('Admin')->prefix('admin')->middleware('admin')->group(function(){

	Route::get('home', 'HomeAdminController@index')->name('admin.home');

	Route::resource('dokumen', 'DokumenSettingController', [
	    'names' => 'admin.setting.dokumen'
	])->except(['create', 'show']);

	Route::get('pengumuman/menu', 'PengumumanController@menu')->name('admin.pengumuman.menu');

	Route::resource('pengumuman', 'PengumumanController', [
	    'names' => 'admin.pengumuman'
	]);

	/*route untuk database setting*/
	Route::prefix('database')->group(function(){

		Route::get('menu', 'DatabaseManagerController@menu')->name('database.menu');

		Route::post('export', 'DatabaseManagerController@export')->name('database.export');

		Route::get('impor', 'DatabaseManagerController@importPage')->name('database.page.impor');

		Route::post('impor', 'DatabaseManagerController@import')->name('database.impor');

	});

});






