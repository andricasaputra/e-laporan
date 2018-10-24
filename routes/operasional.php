<?php

Route::prefix('operasional')->group(function () {

	Route::middleware('kt')->group(function () {

		Route::get('/export', function () {
	    	return view('export');
		})->name('page.export');

		Route::get('/import', function () {
	    	return view('import');
		})->name('page.import');

		Route::get('exportdata', 'Export@export')
		->name('export');

		Route::prefix('kt')->group(function () {

			/*View Page*/
			Route::get('upload/domas', 'DomasKt@sendToUploadDomas')
			->name('kt.upload.page.domas');

			Route::get('upload/dokel', 'DokelKt@sendToUploadDokel')
			->name('kt.upload.page.dokel'); 

			Route::get('upload/ekspor', 'EksporKt@sendToUploadEkspor')
			->name('kt.upload.page.ekspor');

			Route::get('upload/impor', 'ImporKt@sendToUploadImpor')
			->name('kt.upload.page.impor'); 

			/*Proses Upload*/
			Route::post('dokel/importdata', 'DokelKt@imports')
			->name('kt.upload.proses.dokel');

			Route::post('domas/importdata', 'DomasKt@imports')
			->name('kt.upload.proses.domas');

			Route::post('ekspor/importdata', 'EksporKt@imports')
			->name('kt.upload.proses.ekspor');

			Route::post('impor/importdata', 'ImporKt@imports')
			->name('kt.upload.proses.impor');

			/*Export Routes*/

			Route::get('download/domas', function () {
		    	return view('operasional.kt.download.domas');
			})->name('kt.download.page.domas');

			Route::get('download/dokel', function () {
			    return view('operasional.kt.download.dokel');
			})->name('kt.download.page.dokel'); 

			Route::get('download/ekspor', function () {
			    return view('operasional.kt.download.ekspor');
			})->name('kt.download.page.ekspor'); 

			Route::get('download/impor', function () {
			    return view('operasional.kt.download.impor');
			})->name('kt.download.page.impor'); 

			Route::post('dokel/exportdata/{tahun}/{bulan?}', 'DokelKt@exports')
			->name('kt.download.proses.dokel');

			Route::post('domas/exportdata', 'DomasKt@exports')
			->name('kt.download.proses.domas');

			Route::post('ekspor/exportdata', 'EksporKt@exports')
			->name('kt.download.proses.ekspor');

			Route::post('impor/exportdata', 'ImporKt@exports')
			->name('kt.download.proses.impor');

		});/*End Route Prefix KT*/

	});

	/*KH Prefix*/
	Route::middleware('kh')->group(function () {

		Route::get('/export', function () {
	    	return view('export');
		})->name('page.export');

		Route::get('/import', function () {
	    	return view('import');
		})->name('page.import');

		Route::get('exportdata', 'Export@export')
		->name('export');

		Route::prefix('kh')->group(function () {

			/*View Page*/
			Route::get('upload/domas', 'DomasKh@sendToUploadDomas')
			->name('kh.upload.page.domas');

			Route::get('upload/dokel', 'DokelKh@sendToUploadDokel')
			->name('kh.upload.page.dokel'); 

			Route::get('upload/ekspor', 'EksporKh@sendToUploadEkspor')
			->name('kh.upload.page.ekspor');

			Route::get('upload/impor', 'ImporKh@sendToUploadImpor')
			->name('kh.upload.page.impor');

			Route::post('dokel/importdata', 'DokelKh@imports')
			->name('kh.upload.proses.dokel');

			Route::post('domas/importdata', 'DomasKh@imports')
			->name('kh.upload.proses.domas');

			Route::post('ekspor/importdata', 'EksporKh@imports')
			->name('kh.upload.proses.ekspor');

			Route::post('impor/importdata', 'ImporKh@imports')
			->name('kh.upload.proses.impor');

			/*Export Routes*/

			Route::get('download/domas', function () {
		    	return view('operasional.kh.download.domas');
			})->name('kh.download.page.domas');

			Route::get('download/dokel', function () {
			    return view('operasional.kh.download.dokel');
			})->name('kh.download.page.dokel'); 

			Route::get('download/ekspor', function () {
			    return view('operasional.kh.download.ekspor');
			})->name('kh.download.page.ekspor'); 

			Route::get('download/impor', function () {
			    return view('operasional.kh.download.impor');
			})->name('kh.download.page.impor'); 

			Route::post('dokel/exportdata/{tahun}/{bulan?}', 'DokelKh@exports')
			->name('kh.download.proses.dokel');

			Route::post('domas/exportdata', 'DomasKh@exports')
			->name('kh.download.proses.domas');

			Route::post('ekspor/exportdata', 'EksporKh@exports')
			->name('kh.download.proses.ekspor');

			Route::post('impor/exportdata', 'ImporKh@exports')
			->name('kh.download.proses.impor');

		});/*End Route Prefix KT*/

	});

});

