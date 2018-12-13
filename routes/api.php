<?php

Route::post('users', 'UserController@api')->name('api.user');

Route::namespace('Operasional')->group(function () {

	Route::post('kt/dokel/{year}', 'DokelKtController@api')->name('api.kt.dokel');

	Route::post('kt/domas/{year}', 'DomasKtController@api')->name('api.kt.domas');

	Route::post('kt/ekspor/{year}', 'EksporKtController@api')->name('api.kt.ekspor');

	Route::post('kt/impor/{year}', 'ImporKtController@api')->name('api.kt.impor');

	Route::post('kh/dokel/{year}', 'DokelKhController@api')->name('api.kh.dokel');

	Route::post('kh/domas/{year}', 'DomasKhController@api')->name('api.kh.domas');

	Route::post('kh/ekspor/{year}', 'EksporKhController@api')->name('api.kh.ekspor');

	Route::post('kh/impor/{year}', 'ImporKhController@api')->name('api.kh.impor');

	Route::post('data/{year}/{month?}', 'HomeAdminController@dataOperasional')->name('api.data.operasional');

	Route::post('kt/log_operasional/{year?}/{wilker?}', 'HomeKtController@logApi')->name('api.kt.log_operasional');

	Route::post('kh/log_operasional/{year?}/{wilker?}', 'HomeKhController@logApi')->name('api.kh.log_operasional');

});

Route::namespace('Ikm')->group(function () {

	Route::post('ikm/{ikm_id?}', 'HomeController@api')->name('api.ikm');
	
	Route::get('ikm/detail/{id}/{ikm_id?}', 'HomeController@detailApi')->name('api.show');

	Route::get('statistik/ikm/{id?}', 'StatistikController@api')->name('api.statistik');

	Route::get('statistik/grafik/{id?}', 'GrafikController@chartApi')->name('api.grafik');

});

Route::namespace('Notifications')->group(function () {

	Route::post('notifications/all/{user_id}', 'MainNotificationController@mainApiNotifications')
	->name('api.notifications');

});
