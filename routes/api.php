<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('users', 'UserController@api')->name('api.user');

Route::namespace('Operasional')->group(function () {

	Route::post('kt/dokel', 'DokelKt@api')->name('api.kt.dokel');

	Route::post('kt/domas', 'DomasKt@api')->name('api.kt.domas');

	Route::post('kt/ekspor', 'EksporKt@api')->name('api.kt.ekspor');

	Route::post('kt/impor', 'ImporKt@api')->name('api.kt.impor');

	Route::post('kh/dokel', 'DokelKh@api')->name('api.kh.dokel');

	Route::post('kh/domas', 'DomasKh@api')->name('api.kh.domas');

	Route::post('kh/ekspor', 'EksporKh@api')->name('api.kh.ekspor');

	Route::post('kh/impor', 'ImporKh@api')->name('api.kh.impor');

});

