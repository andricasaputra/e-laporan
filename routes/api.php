<?php

Route::post('users', 'UserController@api')->name('api.user');

Route::namespace('Operasional')->group(function () {

	Route::post('kt/dokel/{year}', 'DokelKt@api')->name('api.kt.dokel');

	Route::post('kt/domas/{year}', 'DomasKt@api')->name('api.kt.domas');

	Route::post('kt/ekspor/{year}', 'EksporKt@api')->name('api.kt.ekspor');

	Route::post('kt/impor/{year}', 'ImporKt@api')->name('api.kt.impor');

	Route::post('kh/dokel/{year}', 'DokelKh@api')->name('api.kh.dokel');

	Route::post('kh/domas/{year}', 'DomasKh@api')->name('api.kh.domas');

	Route::post('kh/ekspor/{year}', 'EksporKh@api')->name('api.kh.ekspor');

	Route::post('kh/impor/{year}', 'ImporKh@api')->name('api.kh.impor');

	Route::post('data/{year}/{month?}', 'HomeAdmin@dataOperasional')->name('api.data.operasional');

	Route::post('kt/log_operasional/{year?}/{wilker?}', 'HomeKt@logApi')->name('api.kt.log_operasional');

	Route::post('kh/log_operasional/{year?}/{wilker?}', 'HomeKh@logApi')->name('api.kh.log_operasional');

});

Route::namespace('Ikm')->group(function () {

	Route::post('ikm/{ikm_id?}', 'Home@api')->name('api.ikm');
	
	Route::get('ikm/detail/{id}/{ikm_id?}', 'Home@detailApi')->name('api.show');

	Route::get('statistik/ikm/{id?}', 'Statistik@api')->name('api.statistik');

	Route::get('statistik/grafik/{id?}', 'Grafik@chartApi')->name('api.grafik');

});

Route::namespace('Notifications')->group(function () {

	Route::post('notifications/all/{user_id}', 'MainNotificationController@mainApiNotifications')
	->name('api.notifications');

});
