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

Route::middleware(['auth:api'])->group(function () {
    Route::post('/createshort', 'ApiController@createshort');
    Route::get('/click_chart/{shortcode}', 'ApiController@clicks_of_days');
    Route::get('/device_chart/{shortcode}', 'ApiController@report_device_pie');
    Route::get('/browser_chart/{shortcode}', 'ApiController@report_browser_pie');
    Route::get('/rferrers_chart/{shortcode}', 'ApiController@report_rferrers_pie');
    Route::get('/map_chart/{shortcode}', 'ApiController@report_map');
    Route::get('/click_chart', 'ApiController@clicks_of_days');
    Route::get('/device_chart', 'ApiController@report_device_pie');
    Route::get('/browser_chart', 'ApiController@report_browser_pie');
});
