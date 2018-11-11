<?php

Route::get('home/{year?}', 'HomeKt@show')
->name('show.operasional.kt');

/*View Page*/
Route::get('viewdata/dokel/{year?}', 'DokelKt@sendToData')
->name('kt.view.page.dokel');

Route::get('viewdata/domas/{year?}', 'DomasKt@sendToData')
->name('kt.view.page.domas');

Route::get('viewdata/ekspor/{year?}', 'EksporKt@sendToData')
->name('kt.view.page.ekspor');

Route::get('viewdata/impor/{year?}', 'ImporKt@sendToData')
->name('kt.view.page.impor');

/*KT Upload Routes*/
Route::get('upload/domas', 'DomasKt@sendToUpload')
->name('kt.upload.page.domas');

Route::get('upload/dokel', 'DokelKt@sendToUpload')
->name('kt.upload.page.dokel'); 

Route::get('upload/ekspor', 'EksporKt@sendToUpload')
->name('kt.upload.page.ekspor');

Route::get('upload/impor', 'ImporKt@sendToUpload')
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




