<?php

Route::get('/', function () {
    return 'ini buat website';
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







