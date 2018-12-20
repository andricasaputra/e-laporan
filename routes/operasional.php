<?php

/*post for another year choice all routes on tables kh or kt*/
Route::post('viewdata', 'BaseOperasionalController@DetailTableSelectAnotherYear')
->name('view.select.year');

Route::get('home/{year?}/{month?}/{wilker_id?}', 'HomeAdminController@show')
->name('show.operasional');






