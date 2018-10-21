<?php

Route::prefix('operasional')->group(function () {

	Route::group(['middleware' => ['kt']], function () {

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

			Route::get('upload/dokel', function () {
			    return view('operasional.kt.upload.dokel');
			})->name('kt.upload.page.dokel'); 

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

		});/*End Route Prefix KT*/

	});

});

