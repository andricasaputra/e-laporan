<?php

Auth::routes();

Route::get('/', function () {
    return redirect(route('login'));
});

Route::prefix('operasional')->group(function () {

	Route::get('/admin/home', 'AdminController@index')->name('home');

	Route::get('/kh/home', 'KhController@index')->name('kh.home');

	Route::get('/kt/home', 'KtController@index')->name('kt.home');

});




