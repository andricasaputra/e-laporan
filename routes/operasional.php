<?php

Route::get('home/{year?}/{month?}/{wilker_id?}', 'HomeController@show')
->name('show.operasional');

/*routes untuk admin*/
Route::namespace('Admin')->prefix('admin')->middleware('admin')->group(function(){

	Route::get('home', 'HomeAdminController@index')->name('admin.home');

	Route::resource('dokumen', 'DokumenSettingController', [
	    'names' => 'admin.setting.dokumen'
	])->except(['create', 'show']);

});






