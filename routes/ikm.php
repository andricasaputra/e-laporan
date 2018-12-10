<?php 

Route::prefix('admin')->group(function () {

	Route::get('home/{tahun?}', 'Home@index')
	->name('intern.ikm.home.index');

	Route::get('ikm/show/{responden}/{tahun?}', 'Home@show')
	->name('intern.ikm.home.show');

	Route::get('ikm/statistik/{id?}', 'Statistik@index')
	->name('intern.ikm.statistik.index');

	Route::get('ikm/grafik/{id?}', 'Grafik@index')
	->name('intern.ikm.grafik.index');

	Route::get('ikm/statistik/cetak/{id}', 'Statistik@cetakRekap')
	->name('intern.ikm.statistik.cetak');

	Route::middleware('admin')->group(function () {

		Route::resource('home', 'Home', [
	    	'names' => 'intern.ikm.home'
		])->parameters(['home' => 'responden'])->except(['index', 'show', 'store']);

		Route::resource('answer', 'Answer', [
	    	'names' => 'intern.ikm.answer'     
		])->except(['show']);

		Route::resource('question', 'Questions', [
	    	'names' => 'intern.ikm.question'     
		]);

		Route::resource('pendidikan', 'Pendidikan', [
	    	'names' => 'intern.ikm.pendidikan'     
		])->except(['show']);

		Route::resource('pekerjaan', 'Pekerjaan', [
	    	'names' => 'intern.ikm.pekerjaan'     
		])->except(['show']);

		Route::resource('umur', 'Umur', [
	    	'names' => 'intern.ikm.umur'     
		])->except(['show']);

		Route::resource('layanan', 'Layanan', [
	    	'names' => 'intern.ikm.layanan'     
		])->except(['show']);

		Route::resource('jadwal', 'Jadwal', [
	    	'names' => 'intern.ikm.settingikm'     
		])->except(['show']);

		Route::post('show/{jadwal}', 'Jadwal@show')->name('intern.ikm.settingikm.show');

	});

});

