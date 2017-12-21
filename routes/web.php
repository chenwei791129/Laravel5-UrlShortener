<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@home');

Auth::routes();

Route::get('/admin', 'AdminController@home');
Route::get('/admin/urlmanage', 'AdminController@urlmanage');

Route::get('/{shortcode}', 'UrlShortController@goUrl')->where('shortcode', '[A-Za-z0-9]+');
Route::get('/{shortcode}+', 'AdminController@urlreport')->where('shortcode', '[A-Za-z0-9]+');
