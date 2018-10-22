<?php

Auth::routes();

Route::get('/', function () {
    return redirect(route('login'));
});

Route::middleware('auth')->get('/welcome', function() {
	return view('welcome');
})->name('welcome');

Route::middleware('admin')->get('/welcome_admin', function() {
	return view('welcome_admin');
})->name('welcome.admin');

Route::get('operasional/home', 'HomeController@operasional')->name('home');






