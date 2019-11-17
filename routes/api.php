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

Route::get('wisata/{id?}','ApiController@getWisata');
Route::get('atraksi/{id?}','ApiController@getAtraksi');
Route::get('wisata/{id}/foto','ApiController@getFotoWisata');
Route::get('wisata/{id}/video', 'ApiController@getVideoWisata');
Route::get('kegiatan/{id?}','ApiController@getKegiatan');
Route::get('event/','ApiController@getEvent');
<<<<<<< HEAD
Route::get('kalendar/', 'ApiController@getKalendar');
=======
Route::get('kalendar/{id?}', 'ApiController@getKalender');
>>>>>>> f4a976f95f10b3c142c2ba75977c99e35f0dad8d
