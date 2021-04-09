<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get('/', function (Request $request) {
//     return 'Admin API';
// });

Route::group(['middleware' => ['auth:api']], function () {
	Route::get('/user', function (Request $request) {
	    return $request->user();
	});

    Route::get('/total-hits-overview', 'DashboardController@totalHitsOverview');
    Route::get('/weekly-hits-line-chart', 'DashboardController@weeklyHitsLineChart');
    Route::get('/top-cities-bar-chart', 'DashboardController@topCitiesBarChart');

    Route::get('/users', 'UserController@users');
    Route::get('/user/{user}', 'UserController@user');
    Route::post('/user', 'UserController@store');
    Route::patch('/user/{user}/rename', 'UserController@rename');
    Route::patch('/user/{user}/reset-password', 'UserController@resetPassword');
    Route::delete('/user/{user}', 'UserController@destroy');
    Route::get('/user/components/auth', 'UserController@authUserComponents');
    Route::patch('/user/{user}/components', 'UserController@assignUserComponents');

    Route::get('/page-nodes', 'PageNodeController@pageNodes');
    Route::get('/page-nodes/parent/{parentNode?}', 'PageNodeController@parentPageNodes');
    Route::get('/page-node/{pageNode}', 'PageNodeController@pageNode');
    Route::patch('/page-node/{pageNode}/rename', 'PageNodeController@rename');
    Route::patch('/page-node/{pageNode}/show-or-hide', 'PageNodeController@showOrHide');
    Route::delete('/page-node/{pageNode}', 'PageNodeController@destroy');
    Route::patch('/page-node/{pageNode}/{dirtn}', 'PageNodeController@move');
    Route::get('/pages', 'PageNodeController@pages');
    Route::get('/page/{pageNode}', 'PageNodeController@page');
    Route::post('/page/{parent}', 'PageNodeController@storePage');
    Route::patch('/page-content', 'PageNodeController@updatePageContent');
    Route::post('/page-image', 'PageNodeController@storePageImage');
    Route::get('/page-images', 'PageNodeController@pageImages');
    Route::delete('/page-image', 'PageNodeController@deletePageImage');
    Route::post('/page-file', 'PageNodeController@storePageFile');
    Route::post('/page-section/{parent}', 'PageNodeController@storeSection');
    Route::patch('/page-settings/{pageNode}', 'PageNodeController@updatePageSettings');

    Route::get('/main-menus', 'NavigationController@mainMenus');
    Route::patch('/main-menus', 'NavigationController@updateMainMenus');
    Route::get('/links', 'NavigationController@links');
    Route::post('/link', 'NavigationController@storeLink');
    Route::get('/link/{link}', 'NavigationController@link');
    Route::patch('/link/{link}', 'NavigationController@updateLink');
    Route::delete('/link/{link}', 'NavigationController@destroyLink');
    Route::patch('/link/{link}/up', 'NavigationController@moveUp');
    Route::patch('/link/{link}/down', 'NavigationController@moveDown');

    Route::get('/news-all', 'NewsController@allNews');
    Route::get('/news/{news}', 'NewsController@news');
    Route::post('/news', 'NewsController@store');
    Route::patch('/news/{news}', 'NewsController@update');
    Route::delete('/news/{news}', 'NewsController@destroy');
    Route::post('/news-image', 'NewsController@storeContentImage');
    Route::get('/news-images', 'NewsController@contentImages');
    Route::delete('/news-image', 'NewsController@deleteContentImage');

    Route::get('/announcements', 'AnnouncementController@announcements');
    Route::get('/announcement/{announcement}', 'AnnouncementController@announcement');
    Route::post('/announcement', 'AnnouncementController@store');
    Route::post('/announcement-image', 'AnnouncementController@storeContentImage');
    Route::patch('/announcement/{announcement}', 'AnnouncementController@update');
    Route::get('/announcement-images', 'AnnouncementController@contentImages');
    Route::delete('/announcement-image', 'AnnouncementController@deleteContentImage');
    Route::post('/announcement-file', 'AnnouncementController@storeContentFile');
    Route::delete('/announcement/{announcement}', 'AnnouncementController@destroy');

    Route::get('/job-vacancies', 'JobVacancyController@jobVacancies');
    Route::get('/job-vacancy/{jobVacancy}', 'JobVacancyController@jobVacancy');
    Route::post('/job-vacancy', 'JobVacancyController@store');
    Route::post('/job-vacancy-image', 'JobVacancyController@storeContentImage');
    Route::patch('/job-vacancy/{jobVacancy}', 'JobVacancyController@update');
    Route::get('/job-vacancy-images', 'JobVacancyController@contentImages');
    Route::delete('/job-vacancy-image', 'JobVacancyController@deleteContentImage');
    Route::post('/job-vacancy-file', 'JobVacancyController@storeContentFile');
    Route::delete('/job-vacancy/{jobVacancy}', 'JobVacancyController@destroy');

    Route::post('/calendar-date', 'CalendarDateController@store');
    Route::get('/calendar-dates/{month}/holidays-and-events', 'CalendarDateController@monthHolidaysAndEvents');
    Route::get('/calendar-date/{calendarDate}', 'CalendarDateController@calendarDate');
    Route::patch('/calendar-date/{calendarDate}', 'CalendarDateController@update');
    Route::delete('/calendar-date/{calendarDate}', 'CalendarDateController@destroy');
    Route::post('/calendar-image', 'CalendarDateController@storeContentImage');
    Route::get('/calendar-images', 'CalendarDateController@contentImages');
    Route::delete('/calendar-image', 'CalendarDateController@deleteContentImage');
    Route::get('/events', 'CalendarDateController@events');

    Route::get('/carousel-images', 'CarouselImageController@carouselImages');
    Route::post('/carousel-image', 'CarouselImageController@store');
    Route::get('/carousel-image/{carouselImage}', 'CarouselImageController@carouselImage');
    Route::patch('/carousel-image/{carouselImage}', 'CarouselImageController@update');
    Route::patch('/carousel-image/{carouselImage}/show-or-hide', 'CarouselImageController@showOrHide');
    Route::patch('/carousel-image/{carouselImage}/up', 'CarouselImageController@moveUp');
    Route::patch('/carousel-image/{carouselImage}/down', 'CarouselImageController@moveDown');
    Route::delete('/carousel-image/{carouselImage}', 'CarouselImageController@destroy');

	  Route::get('/albums', 'AlbumController@albums');
	  Route::get('/album/{album}', 'AlbumController@edit');
	  Route::patch('/album/{album}', 'AlbumController@update');
    Route::post('/album', 'AlbumController@store');
    Route::post('/album/photos', 'AlbumController@addPhotos');
    Route::post('/album/{album}/delete', 'AlbumController@destroy'); //delete photos from album
    Route::get('/album/{album}/photos', 'AlbumController@albumPhotos');
    Route::post('/album/{album}/photo/delete', 'AlbumController@deleteAlbumPhoto'); // delete photo from album

    Route::get('/photo/{photo}', 'PhotoController@edit');
    Route::patch('/photo/{photo}', 'PhotoController@updateCaption');


});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
