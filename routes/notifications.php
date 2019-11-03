<?php

Route::post('notification/{id?}/{notify_id?}', 'MainNotificationController@readNotifications')
->name('mark.as.read');

Route::post('mark_as_read_all', 'MainNotificationController@markAsReadAllNotifications')
->name('mark.all.as.read');

Route::get('show_all_notifications', 'MainNotificationController@showAllNotifications')
->name('show.all.notifications');

Route::get('mapnotify', 'MainNotificationController@mapNotifications')
->name('map.notifications');

Route::post('notification_delete', 'MainNotificationController@deleteNotifications')
->name('delete.all.notifications');

