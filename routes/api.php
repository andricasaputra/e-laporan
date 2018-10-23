<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('users', 'UserController@api')->name('api.user');

Route::get('kh/dokel', 'Operasional\\DokelKh@api')->name('api.kh.dokel');