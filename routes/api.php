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
| User API
|
*/

Route::post('users', 'UserController@api')->name('api.user');

/*
|
| E-Operasional API
|
*/

Route::namespace('Operasional')->group(function () {

	/*
	* ----------------------------------------
	* Route API For Dashboard / Ringkasan data
	* ----------------------------------------
	*/

	Route::get('operasional/dashboard/{year?}/{month?}/{wilker_id?}', 'HomeController@api')
	->name('api.operasional.dashboard');

	/*
	* ----------------------------------------------------------
	* Route API For Rekapitulasi Per Kegiatan Laporan bulanan KH
	* ----------------------------------------------------------
	*/

	Route::prefix('kh/rekapitulasi')->group(function(){

		Route::get('dokel/{year?}/{month?}/{wilker_id?}', 'HomeKhController@volumeDokelApiKh')
		->name('api.kh.dokel.rekapitulasi');

		Route::get('domas/{year?}/{month?}/{wilker_id?}', 'HomeKhController@volumeDomasApiKh')
		->name('api.kh.domas.rekapitulasi');

		Route::get('ekspor/{year?}/{month?}/{wilker_id?}', 'HomeKhController@volumeEksporApiKh')
		->name('api.kh.ekspor.rekapitulasi');

		Route::get('impor/{year?}/{month?}/{wilker_id?}', 'HomeKhController@volumeImporApiKh')
		->name('api.kh.impor.rekapitulasi');

		Route::get('detail_tujuan_mp/{class?}/{mp?}/{year?}/{month?}/{wilker_id?}', 'HomeKhController@detailTujuanKh')
		->name('api.kh.detail.tujuan');

	});

	/*
	* ----------------------------------------------------------
	* Route API For Rekapitulasi Per Kegiatan Laporan bulanan KT
	* ----------------------------------------------------------
	*/

	Route::prefix('kt/rekapitulasi')->group(function(){

		Route::get('dokel/{year?}/{month?}/{wilker_id?}', 'HomeKtController@volumeDokelApiKt')
		->name('api.kt.dokel.rekapitulasi');

		Route::get('domas/{year?}/{month?}/{wilker_id?}', 'HomeKtController@volumeDomasApiKt')
		->name('api.kt.domas.rekapitulasi');

		Route::get('ekspor/{year?}/{month?}/{wilker_id?}', 'HomeKtController@volumeEksporApiKt')
		->name('api.kt.ekspor.rekapitulasi');

		Route::get('impor/{year?}/{month?}/{wilker_id?}', 'HomeKtController@volumeImporApiKt')
		->name('api.kt.impor.rekapitulasi');

		Route::get('detail_tujuan_mp/{class?}/{mp?}/{year?}/{month?}/{wilker_id?}', 'HomeKtController@detailTujuanKt')
		->name('api.kt.detail.tujuan');

	});

	/*
	* ------------------------------------------
	* Route API For Detail Table Laporan bulanan
	* ------------------------------------------
	*/

	Route::prefix('kt/statistik')->group(function(){

		Route::post('dokel/{year?}/{month?}/{wilker_id?}', 'DokelKtController@api')
		->name('api.kt.statistik.detail.bigtable.dokel');

		Route::post('domas/{year?}/{month?}/{wilker_id?}', 'DomasKtController@api')
		->name('api.kt.statistik.detail.bigtable.domas');

		Route::post('ekspor/{year?}/{month?}/{wilker_id?}', 'EksporKtController@api')
		->name('api.kt.statistik.detail.bigtable.ekspor');

		Route::post('impor/{year?}/{month?}/{wilker_id?}', 'ImporKtController@api')
		->name('api.kt.statistik.detail.bigtable.impor');

		Route::post('pnbp/{year?}/{month?}/{wilker_id?}', 'ReportBillingKtController@api')
		->name('api.kt.statistik.detail.bigtable.pnbp');

	});

	Route::prefix('kh/statistik')->group(function(){

		Route::post('dokel/{year?}/{month?}/{wilker_id?}', 'DokelKhController@api')
		->name('api.kh.statistik.detail.bigtable.dokel');

		Route::post('domas/{year?}/{month?}/{wilker_id?}', 'DomasKhController@api')
		->name('api.kh.statistik.detail.bigtable.domas');

		Route::post('ekspor/{year?}/{month?}/{wilker_id?}', 'EksporKhController@api')
		->name('api.kh.statistik.detail.bigtable.ekspor');

		Route::post('impor/{year?}/{month?}/{wilker_id?}', 'ImporKhController@api')
		->name('api.kh.statistik.detail.bigtable.impor');

		Route::post('pnbp/{year?}/{month?}/{wilker_id?}', 'ReportBillingKhController@api')
		->name('api.kh.statistik.detail.bigtable.pnbp');

	});

	/*
	* ------------------------------------
	* Route API For Chart Rekapitulasi
	* ------------------------------------
	*/

	Route::get('kh/frekuensi/chart/{type_karantina?}/{year?}/{month?}/{wilker_id?}', 'HomeKhController@frekuensiChartKh')
	->name('api.kh.detail.frekuensi.chart');

	Route::get('kt/frekuensi/chart/{type_karantina?}/{year?}/{month?}/{wilker_id?}', 'HomeKtController@frekuensiChartKt')
	->name('api.kt.detail.frekuensi.chart');

	/*
	* --------------------------------------------
	* Route API For Log Pengiriman Laporan bulanan
	* --------------------------------------------
	*/
	Route::post('kt/log_operasional/{year?}/{month?}/{wilker?}/{type?}', 'HomeKtController@logApi')->name('api.kt.log_operasional');

	Route::post('kh/log_operasional/{year?}/{month?}/{wilker?}/{type?}', 'HomeKhController@logApi')->name('api.kh.log_operasional');

	/*
	* ----------------------
	* Route API For Dokumen
	* ----------------------
	*/

	Route::namespace('Dokumen')->group(function () {

		Route::prefix('kh')->group(function() {

			Route::get('dokumen/penerimaan/{year?}/{month?}/{wilkerId?}', 'PenerimaanDokumenKhController@api')
			->name('api.kh.dokumen.penerimaan');

			Route::get('dokumen/pembatalan/{year?}/{month?}/{wilkerId?}', 'PembatalanDokKhController@api')
			->name('api.kh.dokumen.pembatalan');

		});

		Route::prefix('kt')->group(function() {

			Route::get('dokumen/penerimaan/{year?}/{month?}/{wilkerId?}', 'PenerimaanDokumenKtController@api')
			->name('api.kt.dokumen.penerimaan');

			Route::get('dokumen/pembatalan/{year?}/{month?}/{wilkerId?}', 'PembatalanDokKtController@api')
			->name('api.kt.dokumen.pembatalan');

		}); 

	});

});

/*
|
| E-IKM API
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
| Notifications API
|
*/

Route::namespace('Notifications')->group(function () {

	/*Route API For notifikasi utama*/
	Route::post('notifications/all/{user}', 'MainNotificationController@mainApiNotifications')
	->name('api.notifications');

});
