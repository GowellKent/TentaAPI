<?php

use App\Http\Controllers\FotoObjekController;
use App\Http\Controllers\FotoTransportController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ObjekController;
use App\Http\Controllers\ProvKotaController;
use App\Http\Controllers\TransportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'daerah', 'middleware' => 'auth:sanctum'], function(){
    Route::get('/provinsi', [ProvKotaController::class, 'allProv']);
    Route::get('/kota', [ProvKotaController::class, 'kotaByProv']);
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'isAdmin']], function(){
    Route::group(['prefix' => 'fottran'], function(){
        Route::post('/delete', [FotoTransportController::class, 'delFoto']);
        Route::get('/find', [FotoTransportController::class, 'findFoto']);
    });
    Route::group(['prefix' => 'fotobj'], function(){
        Route::post('/delete', [FotoObjekController::class, 'delFoto']);
        Route::get('/find', [FotoObjekController::class, 'findFoto']);
    });
});

Route::group(['prefix' => 'transport', 'middleware' => 'auth:sanctum'], function(){
    Route::get('/all', [TransportController::class, 'getAll']);
    Route::get('/find', [TransportController::class, 'find']);
    // Route::post('/store', [TransportController::class, 'store']);
    // Route::post('/update', [TransportController::class, 'update']);
    // Route::post('/delete', [TransportController::class, 'delete']);
    Route::post('/search', [TransportController::class, 'searchByRoute']);
});

Route::group(['prefix' => 'objek', 'middleware' => 'auth:sanctum'], function(){
    Route::get('/all', [ObjekController::class, 'getAll']);
    Route::get('/find', [ObjekController::class, 'find']);
    Route::get('/findbyloc', [ObjekController::class, 'findByLoc']);
    Route::get('/jenis', [ObjekController::class, 'jenis']);
    // Route::post('/store', [ObjekController::class, 'store']);
    // Route::post('/update', [ObjekController::class, 'update']);
    // Route::post('/delete', [ObjekController::class, 'delete']);
});

Route::post('/register', [LoginController::class, 'register']);
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logoutAPI']);
Route::get('/revokeall', [LoginController::class, 'revokeAll']);