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

Route::post('register', 'UserController@store');

Route::get('users/{user}/edit', 'UserController@edit')->name('users.edit');

Route::put('admin/{user}/update', 'UserController@updateAdmin')->name('admin.update');





