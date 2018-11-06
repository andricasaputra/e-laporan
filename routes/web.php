<?php

Route::get('/', function () {
    return view('ikm.home');
});

Route::get('/login', function () {
    return redirect(route('login'));
});

Auth::routes();

Route::middleware('auth')->get('intern/welcome', function() {
	return view('intern.welcome');
})->name('welcome');

Route::middleware('admin')->group(function () {

	Route::get('operasional/showall', 'UserController@index')->name('users.show');

	Route::get('operasional/{id}/edit', 'UserController@edit')->name('users.edit');

	Route::put('operasional/{id}/update', 'UserController@update')->name('users.update');

	Route::post('operasional/allusers', 'UserController@allUsers' )->name('users.all');

	Route::get('intern/welcome_admin', function() {
		return view('intern.welcome_admin');
	})->name('welcome.admin');

});

Route::namespace('Operasional')->group(function () {

	Route::get('operasional', 'HomeController@operasional')->name('intern.operasional.home');

});

Route::namespace('Ikm')->group(function () {

	Route::get('ikm', function(){
		return view('ikm.home');
	})->name('ikm.home');

	Route::get('ikm/survey', 'SurveyPage@index')->name('ikm.survey');

	Route::post('ikm/survey', 'SurveyPage@store')->name('ikm.store');

	Route::get('ikm/faq', function(){
		return view('ikm.faq');
	})->name('ikm.faq');

	Route::get('ikm/success/{id}', 'SurveyPage@success')->name('ikm.success');

	Route::get('ikm/cetak/{id}', 'SurveyPage@cetak')->name('ikm.cetak');

});







