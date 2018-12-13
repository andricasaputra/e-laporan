<?php

/*Route::domain('e-office.skp1sumbawabesar.org')->group(function () {*/

    Route::get('/', 'LandingPageController@indexEoffice');

    Route::get('/login', 'LandingPageController@login');

    Auth::routes();

    Route::middleware('auth')->group(function () {

        Route::get('intern/welcome', WelcomeController::class)->name('welcome');

        Route::namespace('Notifications')->group(function () {

            Route::post('intern/notification/{id?}/{notify_id?}', 'MainNotificationController@readNotifications')
            ->name('mark.as.read');

            Route::post('intern/mark_as_read_all', 'MainNotificationController@deleteNotifications')
            ->name('mark.all.as.read');

            Route::get('intern/show_all_notifications', 'MainNotificationController@showAllNotifications')
            ->name('show.all.notifications');
            
            Route::get('intern/mapnotify', 'MainNotificationController@mapNotifications')
            ->name('map.notifications');

            Route::post('intern/notification_delete', 'MainNotificationController@deleteNotifications')
            ->name('delete.all.notifications');

        });

    });

    /*
    |
    |Redirect User Ke E-Operasional Sesuai Role dan Bagian (KH/KT)
    |
    */

    Route::namespace('Operasional')->group(function () {

        Route::get('intern/operasional', 'HomeMiddleware@operasional')->name('intern.operasional.home');

    });

/*});*//*End Domain e-Office*/

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

/*});*//*End Domain IKM*/









