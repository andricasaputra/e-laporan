<?php

/*
|--------------------------------------------------------------------------
| API Routes - All Aplications
|--------------------------------------------------------------------------
|
| Routing untuk API / Endpoint hanya untuk view resource
| atau tampilan data saja sehingga tidak perlu menggunakan authentifikasi
| untuk dapat melihat data - data  dari route ini
|
*/

/*
|
|User API
|
*/

Route::post('users', 'UserController@api')->name('api.user');

/*
|
|E-Operasional API
|
*/

Route::namespace('Operasional')->group(function () {

	/*Route API For Detail Table Laporan bulanan*/
	Route::post('kt/statistik/detail/frekuensi/dokel/{year?}/{month?}/{wilker_id?}', 'DokelKtController@api')->name('api.kt.detail.frekuensi.dokel');

	Route::post('kt/statistik/detail/frekuensi/domas/{year?}/{month?}/{wilker_id?}', 'DomasKtController@api')->name('api.kt.detail.frekuensi.domas');

	Route::post('kt/statistik/detail/frekuensi/ekspor/{year?}/{month?}/{wilker_id?}', 'EksporKtController@api')->name('api.kt.detail.frekuensi.ekspor');

	Route::post('kt/statistik/detail/frekuensi/impor/{year?}/{month?}/{wilker_id?}', 'ImporKtController@api')->name('api.kt.detail.frekuensi.impor');

	Route::post('kh/statistik/detail/frekuensi/dokel/{year?}/{month?}/{wilker_id?}', 'DokelKhController@api')->name('api.kh.detail.frekuensi.dokel');

	Route::post('kh/statistik/detail/frekuensi/domas/{year?}/{month?}/{wilker_id?}', 'DomasKhController@api')->name('api.kh.detail.frekuensi.domas');

	Route::post('kh/statistik/detail/frekuensi/ekspor/{year?}/{month?}/{wilker_id?}', 'EksporKhController@api')->name('api.kh.detail.frekuensi.ekspor');

	Route::post('kh/statistik/detail/frekuensi/impor/{year?}/{month?}/{wilker_id?}', 'ImporKhController@api')->name('api.kh.detail.frekuensi.impor');

	/*Route API For Ringaksan Data in landing Page Laporan bulanan*/
	Route::get('data/{year}/{month?}/{wilker_id?}', 'HomeAdminController@dataOperasional')
	->name('api.data.operasional');

	/*Route API For Rekapitulasi Per Kegiatan Laporan bulanan KH*/
	Route::get('kh/dokel/rekapitulasi/{year?}/{month?}/{wilker_id?}', 'HomeKhController@dataVolumeDokelApiKh')
	->name('api.kh.dokel.rekapitulasi');

	Route::get('kh/domas/rekapitulasi/{year?}/{month?}/{wilker_id?}', 'HomeKhController@dataVolumeDomasApiKh')
	->name('api.kh.domas.rekapitulasi');

	Route::get('kh/ekspor/rekapitulasi/{year?}/{month?}/{wilker_id?}', 'HomeKhController@dataVolumeEksporApiKh')
	->name('api.kh.ekspor.rekapitulasi');

	Route::get('kh/impor/rekapitulasi/{year?}/{month?}/{wilker_id?}', 'HomeKhController@dataVolumeImporApiKh')
	->name('api.kh.impor.rekapitulasi');

	Route::get('kh/rekapitulasi/detail_tujuan_mp/{class?}/{mp?}/{year?}/{month?}/{wilker_id?}', 'HomeKhController@detailTujuanKh')
	->name('api.kh.detail.tujuan');

	/*Route API For Rekapitulasi Per Kegiatan Laporan bulanan KT*/
	Route::get('kt/dokel/rekapitulasi/{year?}/{month?}/{wilker_id?}', 'HomeKtController@dataVolumeDokelApiKt')
	->name('api.kt.dokel.rekapitulasi');

	Route::get('kt/domas/rekapitulasi/{year?}/{month?}/{wilker_id?}', 'HomeKtController@dataVolumeDomasApiKt')
	->name('api.kt.domas.rekapitulasi');

	Route::get('kt/ekspor/rekapitulasi/{year?}/{month?}/{wilker_id?}', 'HomeKtController@dataVolumeEksporApiKt')
	->name('api.kt.ekspor.rekapitulasi');

	Route::get('kt/impor/rekapitulasi/{year?}/{month?}/{wilker_id?}', 'HomeKtController@dataVolumeImporApiKt')
	->name('api.kt.impor.rekapitulasi');

	Route::get('kt/rekapitulasi/detail_tujuan_mp/{class?}/{mp?}/{year?}/{month?}/{wilker_id?}', 'HomeKtController@detailTujuanKt')
	->name('api.kt.detail.tujuan');

	/*Route API For Chart Rekapitulasi*/
	Route::get('kh/rekapitulasi/chart/{type_karantina?}/{year?}/{month?}/{wilker_id?}', 'HomeKhController@frekuensiPerMonthChartKh')
	->name('api.kh.detail.frekuensi.chart');

	Route::get('kt/rekapitulasi/chart/{type_karantina?}/{year?}/{month?}/{wilker_id?}', 'HomeKtController@frekuensiPerMonthChartKt')
	->name('api.kt.detail.frekuensi.chart');

	/*Route API For Log Pengiriman Laporan bulanan*/
	Route::post('kt/log_operasional/{year?}/{wilker?}', 'HomeKtController@logApi')->name('api.kt.log_operasional');

	Route::post('kh/log_operasional/{year?}/{wilker?}', 'HomeKhController@logApi')->name('api.kh.log_operasional');

});

/*
|
|E-IKM API
|
*/

Route::namespace('Ikm')->group(function () {

	/*Route API For tabel utama e-ikm*/
	Route::post('ikm/{ikm_id?}', 'HomeController@api')->name('api.ikm');
	
	/*Route API For detail pertanyaan e-ikm*/
	Route::get('ikm/detail/{id}/{ikm_id?}', 'HomeController@detailApi')->name('api.show');

	/*Route API For data statistik e-ikm*/
	Route::get('statistik/ikm/{id?}', 'StatistikController@api')->name('api.statistik');

	/*Route API For data grafik e-ikm*/
	Route::get('statistik/grafik/{id?}', 'GrafikController@chartApi')->name('api.grafik');

});

/*
|
|Notifications API
|
*/

Route::namespace('Notifications')->group(function () {

	/*Route API For notifikasi utama*/
	Route::post('notifications/all/{user}', 'MainNotificationController@mainApiNotifications')
	->name('api.notifications');

});
