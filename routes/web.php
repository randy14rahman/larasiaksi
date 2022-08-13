<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Zend\Debug\Debug;

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

Route::group(['namespace' => 'App\Http\Controllers'], function () {

    Auth::routes();

    Route::group(['middleware' => ['guest']], function () {
    });

    Route::group(['middleware' => ['auth']], function () {

        Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
        Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'users'])->name('users')->middleware('auth');
        Route::get('/admin/roles', [App\Http\Controllers\AdminController::class, 'roles'])->name('roles')->middleware('auth');
        Route::get('/surat-masuk', [App\Http\Controllers\SuratMasukController::class, 'index'])->name('surat-masuk.index');

        Route::get('/surat-masuk/detail/{id}', [App\Http\Controllers\SuratMasukController::class, 'detail'])->name('surat-masuk.detail');

        Route::get('/surat-keluar', [App\Http\Controllers\SuratKeluarController::class, 'index'])->name('surat-keluar.index');

        Route::get('/arsip', [App\Http\Controllers\ArsipController::class, 'index'])->name('arsip.index');


        Route::group(['prefix' => 'api'], function() {
            Route::get('/get-pemaraf/{user_id}/user', [App\Http\Controllers\UserController::class, 'getPemarafByUser']);
            Route::get('/get-pemaraf/{level}/level', [App\Http\Controllers\UserController::class, 'getPemarafByLevel']);

            Route::get('surat-masuk/arsip', [App\Http\Controllers\SuratMasukController::class, 'listArsip'])->name('surat-masuk.listArsip');

            Route::get('/surat-keluar', [App\Http\Controllers\SuratKeluarController::class, 'listSurat'])->name('surat-keluar.listSurat');
            Route::get('/surat-keluar/arsip', [App\Http\Controllers\SuratKeluarController::class, 'listArsip'])->name('surat-keluar.listArsip');
            Route::post('/surat-keluar', [App\Http\Controllers\SuratKeluarController::class, 'addSurat'])->name('surat-keluar.addSurat');
            Route::put('/surat-keluar/{id}/paraf1', [App\Http\Controllers\SuratKeluarController::class, 'setActiveParaf1'])->name('surat-keluar.setActiveParaf1');
            Route::put('/surat-keluar/{id}/paraf2', [App\Http\Controllers\SuratKeluarController::class, 'setActiveParaf2'])->name('surat-keluar.setActiveParaf2');
            Route::put('/surat-keluar/{id}/ttd', [App\Http\Controllers\SuratKeluarController::class, 'setTtd'])->name('surat-keluar.setTtd');

        });
    });

});