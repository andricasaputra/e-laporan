<?php 

Route::prefix('admin')->group(function () {

	Route::get('home/{tahun?}', 'HomeController@index')
	->name('intern.ikm.home.index');

	Route::prefix('ikm')->group(function(){

		Route::get('show/{responden}/{tahun?}', 'HomeController@show')
		->name('intern.ikm.home.show');

		Route::get('cetak_multiple/{ikmId}', 'HomeController@cetakMultiple')
		->name('intern.ikm.home.masscetak');

		Route::get('statistik/{id?}', 'StatistikController@index')
		->name('intern.ikm.statistik.index');

		Route::get('grafik/{id?}', 'GrafikController@index')
		->name('intern.ikm.grafik.index');

		Route::get('statistik/cetak/{id}', 'StatistikController@cetakRekap')
		->name('intern.ikm.statistik.cetak');

	});

	Route::middleware('admin')->group(function () {

		Route::resource('home', 'HomeController', [
	    	'names' => 'intern.ikm.home'
		])->parameters(['home' => 'responden'])->except(['index', 'show', 'store']);

		Route::resource('answer', 'AnswerController', [
	    	'names' => 'intern.ikm.answer'     
		])->except(['show']);

		Route::resource('question', 'QuestionsController', [
	    	'names' => 'intern.ikm.question'     
		]);

		Route::resource('pendidikan', 'PendidikanController', [
	    	'names' => 'intern.ikm.pendidikan'     
		])->except(['show']);

		Route::resource('pekerjaan', 'PekerjaanController', [
	    	'names' => 'intern.ikm.pekerjaan'     
		])->except(['show']);

		Route::resource('umur', 'UmurController', [
	    	'names' => 'intern.ikm.umur'     
		])->except(['show']);

		Route::resource('layanan', 'LayananController', [
	    	'names' => 'intern.ikm.layanan'     
		])->except(['show']);

		Route::resource('jadwal', 'JadwalController', [
	    	'names' => 'intern.ikm.settingikm'     
		])->except(['show']);

		Route::post('show/{jadwal}', 'JadwalController@show')->name('intern.ikm.settingikm.show');

	});

});

