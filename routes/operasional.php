<?php

Route::prefix('operasional')->group(function () {

	Route::middleware('kt')->group(function () {

		Route::get('/export', function () {
	    	return view('export');
		})->name('page.export');

		Route::get('/import', function () {
	    	return view('import');
		})->name('page.import');

		Route::get('exportdata', 'Export@export')->name('export');

		Route::prefix('kt')->group(function () {

			Route::get('upload/domas', function () {
		    	return view('operasional.kt.upload.domas');
			})->name('kt.upload.page.domas');

			Route::get('upload/dokel', 'DokelKt@sendToUploadDokel')->name('kt.upload.page.dokel'); 

			Route::get('upload/ekspor', function () {
			    return view('operasional.kt.upload.ekspor');
			})->name('kt.upload.page.ekspor'); 

			Route::get('upload/impor', function () {
			    return view('operasional.kt.upload.impor');
			})->name('kt.upload.page.impor'); 

			Route::post('dokel/importdata', 'DokelKt@imports')->name('kt.upload.proses.dokel');

			Route::post('domas/importdata', 'DomasKt@imports')->name('kt.upload.proses.domas');

			Route::post('ekspor/importdata', 'EksporKt@imports')->name('kt.upload.proses.ekspor');

			Route::post('impor/importdata', 'ImporKt@imports')->name('kt.upload.proses.impor');

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

			Route::post('dokel/exportdata/{tahun}/{bulan?}', 'DokelKt@exports')->name('kt.download.proses.dokel');

			Route::post('domas/exportdata', 'DomasKt@exports')->name('kt.download.proses.domas');

			Route::post('ekspor/exportdata', 'EksporKt@exports')->name('kt.download.proses.ekspor');

			Route::post('impor/exportdata', 'ImporKt@exports')->name('kt.download.proses.impor');

		});/*End Route Prefix KT*/

	});

});

