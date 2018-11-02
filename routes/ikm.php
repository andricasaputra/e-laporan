<?php 

Route::prefix('admin')->group(function () {

	Route::resource('home', 'HomeAdminIkm', [
    	'names' => 'intern.ikm'
	]);

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

});

