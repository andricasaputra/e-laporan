<?php

/*post for another year choice all routes on tables kh or kt*/
Route::post('viewdata', 'BaseOperasional@selectAnotherYear')
->name('view.select.year');

Route::prefix('admin')->group(function () {

	Route::get('home/{year?}/{month?}', 'HomeAdmin@show')
	->name('show.operasional');

});

/*KT Prefix*/
Route::middleware('kt')->prefix('kt')->group(function () {

	include_once('operasionalkt.php');

});

/*KH Prefix*/
Route::middleware('kh')->prefix('kh')->group(function () {

	include_once('operasionalkh.php');

});




