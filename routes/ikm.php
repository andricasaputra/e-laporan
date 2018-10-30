<?php 

Route::prefix('admin')->group(function () {

	Route::resource('home', 'HomeAdminIkm', [
    	'names' => 'intern.ikm'
	]);

	Route::resource('answer', 'Answer', [
    	'names' => 'intern.ikm.answer'     
	])->except(['show']);

});

