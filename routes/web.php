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
*/Route::group(['namespace' => 'App\Http\Controllers'], function()
{

    Auth::routes();
    
    Route::group(['middleware' => ['guest']], function() {
    });

    Route::group(['middleware' => ['auth']], function() {

        Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
        Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'users'])->name('users')->middleware('auth');
        Route::get('/admin/roles', [App\Http\Controllers\AdminController::class, 'roles'])->name('roles')->middleware('auth');
        Route::get('/surat-masuk', [App\Http\Controllers\SuratMasukController::class, 'index'])->name('surat-masuk.index');
        Route::get('/surat-keluar', [App\Http\Controllers\SuratKeluarController::class, 'index'])->name('surat-masuk.index');
        Route::get('/arsip', [App\Http\Controllers\ArsipController::class, 'index'])->name('arsip.index');
    });

});