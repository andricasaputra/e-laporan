<?php

Route::get('home/{year?}', 'HomeKh@show')
->name('show.operasional.kh');

/*View Page*/
Route::get('viewdata/dokel/{year?}', 'DokelKh@sendToData')
->name('kh.view.page.dokel');

Route::get('viewdata/domas/{year?}', 'DomasKh@sendToData')
->name('kh.view.page.domas');

Route::get('viewdata/ekspor/{year?}', 'EksporKh@sendToData')
->name('kh.view.page.ekspor');

Route::get('viewdata/impor/{year?}', 'ImporKh@sendToData')
->name('kh.view.page.impor');

/*KH Upload Routes*/
Route::get('upload/domas', 'DomasKh@sendToUpload')
->name('kh.upload.page.domas');

Route::get('upload/dokel', 'DokelKh@sendToUpload')
->name('kh.upload.page.dokel'); 

Route::get('upload/ekspor', 'EksporKh@sendToUpload')
->name('kh.upload.page.ekspor');

Route::get('upload/impor', 'ImporKh@sendToUpload')
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
/*Route::get('download/domas', function () {
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
})->name('kh.download.page.impor'); */

Route::post('dokel/exportdata/{tahun}/{bulan?}', 'DokelKh@exports')
->name('kh.download.proses.dokel');

Route::post('domas/exportdata', 'DomasKh@exports')
->name('kh.download.proses.domas');

Route::post('ekspor/exportdata', 'EksporKh@exports')
->name('kh.download.proses.ekspor');

Route::post('impor/exportdata', 'ImporKh@exports')
->name('kh.download.proses.impor');


