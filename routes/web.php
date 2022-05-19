<?php

use Illuminate\Support\Facades\Artisan;
use Spatie\ResponseCache\Facades\ResponseCache;

/*Route::domain('e-office.skp1sumbawabesar.org')->group(function () {*/

    Route::get('/', 'LandingPageController@indexEoffice');

    Route::get('/login', 'LandingPageController@login');

    Route::post('/sso', 'Auth\\LoginController@autoLogin')->name('sso.login');

    Route::get('/logout', 'Auth\\LoginController@logout')->name('logout');

    Auth::routes();

    Route::get('intern/welcome', WelcomeController::class)->middleware('auth')->name('welcome');

    /*
    |
    |Redirect User Ke E-Operasional Sesuai Role dan Bagian (KH/KT)
    |
    */

    Route::namespace('Operasional')->group(function () {

        Route::get('intern/operasional', 'RoleSetterController@handle');

    });

    Route::get('view-clear', function(){
        Artisan::call('view:clear');
    });

    Route::get('route-clear', function(){
        Artisan::call('route:clear');
    });

    Route::get('config-clear', function(){
        Artisan::call('config:clear');
    });

    Route::get('clear-all', function(){
        ResponseCache::clear();
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');

        return redirect()->route('show.operasional');
    });

/*});*/

/*
|
|Route Untuk IKM Survey Pengguna Jasa / Ekstern Link 
|
*/

/*Route::domain('ikm.skp1sumbawabesar.org')->group(function () {*/

	Route::get('/ikm', 'LandingPageController@indexEIkm');

    Route::namespace('Ikm')->group(function(){

    	Route::get('home', 'SurveyPageController@home')->name('ikm.home');

	    Route::get('ikm/faq', 'SurveyPageController@faq')->name('ikm.faq');

	    Route::get('ikm/survey', 'SurveyPageController@index')->name('ikm.survey');

	    Route::post('ikm/survey', 'SurveyPageController@store')->name('ikm.store');

	    Route::get('ikm/success/{responden}', 'SurveyPageController@success')->name('ikm.success');

	    Route::get('ikm/cetak/{responden}', 'SurveyPageController@cetak')->name('ikm.cetak');

	    Route::get('ikm/survey/closed', 'SurveyPageController@surveyClosed')->name('ikm.closed');

    });

/*});*/









