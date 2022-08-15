<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user-list');
Route::post('/user', [App\Http\Controllers\UserController::class, 'addUser'])->name('add-user');
Route::put('/user/{user_id}', [App\Http\Controllers\UserController::class, 'editUser'])->name('edit-user');
Route::delete('/user/{user_id}', [App\Http\Controllers\UserController::class, 'deleteUser'])->name('delete-user');


Route::get('/role', [App\Http\Controllers\Api\RoleController::class, 'index']);
Route::post('/role', [App\Http\Controllers\Api\RoleController::class, 'addRole']);
Route::put('/role/{role_id}', [App\Http\Controllers\Api\RoleController::class, 'editRole']);
Route::delete('/role/{role_id}', [App\Http\Controllers\Api\RoleController::class, 'deleteRole']);

Route::get('/surat-masuk/list-disposisi-assign', [App\Http\Controllers\SuratMasukController::class, 'getListDisposisiAssign'])->name('list-disposisi-assign');
Route::get('/surat-masuk/get-tracking', [App\Http\Controllers\SuratMasukController::class, 'getTrackingList'])->name('get-tracking');
Route::post('/surat-masuk/proses-surat', [App\Http\Controllers\SuratMasukController::class, 'processSurat'])->name('proses-surat-masuk');

