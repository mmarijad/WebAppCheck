<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home/store', 'HomeController@store');

Route::get('/apps', 'AppController@index')->name('apps');
Route::post('/apps/store', 'AppController@store');
Route::get('/apps/delete{id}', 'AppController@delete');
Route::get('/apps/check{id}', 'AppController@check');
Route::get('/app_details{id}', 'AppController@details');
Route::get('laravel-google-pie-chart', 'GooglePieController@index');


Route::get("email", "NotificationmailController@sendEmail");
