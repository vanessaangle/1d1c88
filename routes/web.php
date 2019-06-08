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

Route::get('/', function () {
    return redirect('/dashboard');
});

Auth::routes();
Route::middleware(['auth'])->group(function(){
    Route::get('/dashboard','DashboardController@index')->name('admin.dashboard.index');
    Route::get('/dasasdahboard','DashboardController@index')->name('admin.user.profile');
    Route::get('/logout','Auth\\LoginController@index')->name('admin.auth.logout');
    Route::name('admin.')->group(function(){
        Route::resources([
            '/user' => 'UserController',
            '/desa' => 'DesaController',
            '/desa-wisata' => 'DesaWisataController',
            '/event' => 'EventController'
        ]);
    });
    Route::get('desa-wisata/{kegiatan_id}/kegiatan','KegiatanController@index')->name('admin.tempat_wisata.kegiatan.index');
    Route::get('desa-wisata/{kegiatan_id}/kegiatan/create','KegiatanController@create')->name('admin.tempat_wisata.kegiatan.create');
    Route::get('desa-wisata/{kegiatan_id}/kegiatan/{id}/edit','KegiatanController@edit')->name('admin.tempat_wisata.kegiatan.edit');
    Route::post('tempat_wisata/{kegiatan_id}/kegiatan','KegiatanController@store')->name('admin.tempat_wisata.kegiatan.store');
    Route::put('tempat_wisata/{kegiatan_id}/kegiatan/{id}','KegiatanController@update')->name('admin.tempat_wisata.kegiatan.update');
    Route::get('tempat_wisata/{kegiatan_id}/kegiatan/{id}','KegiatanController@show')->name('admin.tempat_wisata.kegiatan.show');
    Route::delete('tempat_wisata/{kegiatan_id}/kegiatan/{id}','KegiatanController@destroy')->name('admin.tempat_wisata.kegiatan.destroy');

    Route::get('desa-wisata/{kegiatan_id}/foto','FotoController@index')->name('admin.tempat_wisata.foto.index');
    Route::get('desa-wisata/{kegiatan_id}/foto/create','FotoController@create')->name('admin.tempat_wisata.foto.create');
    Route::get('desa-wisata/{kegiatan_id}/foto/{id}/edit','FotoController@index')->name('admin.tempat_wisata.foto.edit');
    Route::post('tempat_wisata/{kegiatan_id}/foto','FotoController@store')->name('admin.tempat_wisata.foto.store');
    Route::get('tempat_wisata/{kegiatan_id}/foto/{id}','FotoController@show')->name('admin.tempat_wisata.foto.show');
    Route::delete('tempat_wisata/{kegiatan_id}/foto/{id}','FotoController@destroy')->name('admin.tempat_wisata.foto.destroy');

    Route::get('desa-wisata/{kegiatan_id}/video','VideoController@index')->name('admin.tempat_wisata.video.index');
    Route::get('desa-wisata/{kegiatan_id}/video/create','VideoController@create')->name('admin.tempat_wisata.video.create');
    Route::get('desa-wisata/{kegiatan_id}/video/{id}/edit','VideoController@index')->name('admin.tempat_wisata.video.edit');
    Route::post('tempat_wisata/{kegiatan_id}/video','VideoController@store')->name('admin.tempat_wisata.video.store');
    Route::get('tempat_wisata/{kegiatan_id}/video/{id}','VideoController@show')->name('admin.tempat_wisata.video.show');
    Route::delete('tempat_wisata/{kegiatan_id}/video/{id}','VideoController@destroy')->name('admin.tempat_wisata.video.destroy');
});