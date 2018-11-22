<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users', 'UserController@api')->name('api.user');

Route::namespace('Operasional')->group(function () {

	Route::post('kt/dokel/{year}', 'DokelKt@api')->name('api.kt.dokel');

	Route::post('kt/domas/{year}', 'DomasKt@api')->name('api.kt.domas');

	Route::post('kt/ekspor/{year}', 'EksporKt@api')->name('api.kt.ekspor');

	Route::post('kt/impor/{year}', 'ImporKt@api')->name('api.kt.impor');

	Route::post('kh/dokel/{year}', 'DokelKh@api')->name('api.kh.dokel');

	Route::post('kh/domas/{year}', 'DomasKh@api')->name('api.kh.domas');

	Route::post('kh/ekspor/{year}', 'EksporKh@api')->name('api.kh.ekspor');

	Route::post('kh/impor/{year}', 'ImporKh@api')->name('api.kh.impor');

	Route::get('data/{year}/{month?}', 'HomeAdmin@dataOperasional');

});

Route::namespace('Ikm')->group(function () {

	Route::get('ikm/{ikm_id}', 'Home@api')->name('api.ikm');
	
	Route::get('ikm/detail/{id}/{ikm_id?}', 'Home@detailApi')->name('api.show');

	Route::get('statistik/ikm/{id?}', 'Statistik@api')->name('api.statistik');

	Route::get('statistik/grafik/{id?}', 'Grafik@chartApi')->name('api.grafik');

});

