<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;

use Zend\Debug\Debug;

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

Route::controller(AuthController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group( function () {
    Route::group(['prefix' => 'v2'], function() {
        Route::get('/get-pemaraf/{user_id}/user', [App\Http\Controllers\UserController::class, 'getPemarafByUser']);
        Route::get('/get-pemaraf/{level}/level', [App\Http\Controllers\UserController::class, 'getPemarafByLevel']);

        Route::get('/surat-masuk', [App\Http\Controllers\SuratMasukController::class, 'getSuratMasuk'])->name('get-surat-masuk');
        Route::post('/surat-masuk', [App\Http\Controllers\SuratMasukController::class, 'addSuratMasuk'])->name('add-surat-masuk');
        Route::delete('/surat-masuk/{id}', [App\Http\Controllers\SuratMasukController::class, 'deleteSuratMasuk'])->name('delete-surat-masuk');
        Route::get('/surat-masuk/{id}/detail', [App\Http\Controllers\SuratMasukController::class, 'getDetailSuratMasuk'])->name('get-detail-surat-masuk');
        Route::get('/surat-masuk/arsip', [App\Http\Controllers\SuratMasukController::class, 'listArsip'])->name('surat-masuk.listArsip');            
        Route::get('/surat-masuk/list-disposisi-assign', [App\Http\Controllers\SuratMasukController::class, 'getListDisposisiAssign'])->name('list-disposisi-assign');
        Route::post('/surat-masuk/disposisi-surat', [App\Http\Controllers\SuratMasukController::class, 'disposisiSurat'])->name('disposisi-surat-masuk');
        Route::post('/surat-masuk/{id}/proses-surat', [App\Http\Controllers\SuratMasukController::class, 'prosesSurat'])->name('proses-surat-masuk');
        Route::post('/surat-masuk/{id}/arsipkan-surat', [App\Http\Controllers\SuratMasukController::class, 'arsipkanSurat'])->name('arsipkan-surat-masuk');
        Route::get('/surat-masuk/{id}/tracking', [App\Http\Controllers\SuratMasukController::class, 'getTrackingList'])->name('get-tracking');

        Route::get('/surat-keluar', [App\Http\Controllers\SuratKeluarController::class, 'listSurat'])->name('surat-keluar.listSurat');
        Route::get('/surat-keluar/arsip', [App\Http\Controllers\SuratKeluarController::class, 'listArsip'])->name('surat-keluar.listArsip');
        Route::post('/surat-keluar', [App\Http\Controllers\SuratKeluarController::class, 'addSurat'])->name('surat-keluar.addSurat');
        Route::put('/surat-keluar/{id}/paraf1', [App\Http\Controllers\SuratKeluarController::class, 'setActiveParaf1'])->name('surat-keluar.setActiveParaf1');
        Route::put('/surat-keluar/{id}/paraf2', [App\Http\Controllers\SuratKeluarController::class, 'setActiveParaf2'])->name('surat-keluar.setActiveParaf2');
        Route::put('/surat-keluar/{id}/ttd', [App\Http\Controllers\SuratKeluarController::class, 'setTtd'])->name('surat-keluar.setTtd');
        Route::post('/surat-keluar/upload-signed', [App\Http\Controllers\SuratKeluarController::class, 'uploadTtd'])->name('upload-surat-signed');
        
        Route::get('/notification', [App\Http\Controllers\NotificationController::class, 'index'])->name('get-notification');
    });
});

// Route::post('/auth', [App\Http\Controllers\Api\AuthController::class, 'login'])->name('auth.login');