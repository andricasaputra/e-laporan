<?php

Route::get('/', function () {

    return redirect(route('ikm.home'));

});

Route::get('/login', function () {

    return redirect(route('login'));
    
});

Auth::routes();

Route::middleware('auth')->get('intern/welcome', function() {

	return view('intern.welcome');

})->name('welcome');

/*
|
|Redirect User Ke E-Operasional Sesuai Role dan Bagian (KH/KT)
|
*/

Route::namespace('Operasional')->group(function () {

	Route::get('intern/operasional', 'HomeMiddleware@operasional')->name('intern.operasional.home');

});

/*
|
|Route Untuk IKM Survey Pengguna Jasa / Ekstern Link 
|
*/

Route::namespace('Ikm')->group(function () {

	Route::get('ikm', function(){

		return view('ikm.home');

	})->name('ikm.home');

	Route::get('ikm/faq', function(){

		return view('ikm.faq');

	})->name('ikm.faq');

	Route::get('ikm/survey', 'SurveyPage@index')->name('ikm.survey');

	Route::post('ikm/survey', 'SurveyPage@store')->name('ikm.store');

	Route::get('ikm/success/{id}', 'SurveyPage@success')->name('ikm.success');

	Route::get('ikm/cetak/{id}', 'SurveyPage@cetak')->name('ikm.cetak');

	Route::get('ikm/survey/closed', function(){
		return view('ikm.closed');
	})->name('ikm.closed');

});







