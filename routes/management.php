<?php

/*
|
|Aplikasi Manajemen Routes
|
*/

/*Users Manajemen*/
Route::resource('users', 'UserController')->only([

	'index', 'update', 'destroy'

])->parameters([

	'users' => 'masterPegawai'

]);

Route::get('register', 'UserController@showRegistrationForm')->name('register');

Route::post('register', 'UserController@create');

Route::get('users/{user}/edit', 'UserController@edit')->name('users.edit');






