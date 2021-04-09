<?php

Route::get('/', function () {
    return 'Public APIs';
});

Route::get('/main-menu', 'AppController@mainMenu');
Route::get('/analytics/overview', 'AppController@analyticsOverview');
Route::get('/auxiliary-menu', 'AppController@auxiliaryMenu');
Route::get('/carousel', 'HomeController@carousel');
Route::get('/home-news', 'HomeController@news');
Route::get('/home-announcements', 'HomeController@announcements');
Route::get('/page/{slug}', 'PageController@page');
Route::get('/announcement/{slug}', 'AnnouncementController@announcement');
Route::get('/news/{slug}', 'NewsController@news');
Route::get('/calendar-dates/{month}/holidays-and-events', 'HomeController@monthHolidaysAndEvents');

Route::get('/latest-news', 'SidebarController@latestNews');
Route::get('/latest-announcements', 'SidebarController@latestAnnouncements');
Route::get('/links', 'SidebarController@links');

Route::get('/job-vacancies/{slug}', 'JobVacancyController@jobVacancy');
Route::get('/news', 'NewsController@list');
Route::get('/announcements', 'AnnouncementController@list');
Route::get('/job-vacancies', 'JobVacancyController@list');

Route::post('/feedback', 'MailController@feedback');
