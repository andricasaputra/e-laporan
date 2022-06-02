<?php

Route::get('/epersonal/index/{year?}/{month?}', 'EpersonalController@index')->name('epersonal.index');

Route::post('/epersonal/get-skp', 'EpersonalController@getSkp')->name('epersonal.getskp');

Route::get('/epersonal/table/{year?}/{month?}', 'EpersonalController@tableApi')->name('epersonal.table.api');

Route::get('/epersonal/butir_kegiatan/{jabatan?}', 'EpersonalController@butirKegiatan')->name('epersonal.butir');
















