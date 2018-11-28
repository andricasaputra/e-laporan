<?php

/*
|
|Aplikasi Manajemen Routes
|
*/

/*Users Manajemen*/
Route::resource('users', 'UserController')->only([

	'index', 'edit', 'update', 'destroy'

])->parameters([

	'users' => 'id'

]);






