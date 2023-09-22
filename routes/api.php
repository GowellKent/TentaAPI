<?php

use App\Http\Controllers\FotoObjekController;
use App\Http\Controllers\FotoTransportController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ObjekController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\ProvKotaController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\TransportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;

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

//group route daerah ==========================================================================================================================================
Route::group(['prefix' => 'daerah'], function(){
    Route::get('/provinsi', [ProvKotaController::class, 'allProv']);
    Route::get('/kota', [ProvKotaController::class, 'kotaByProv']);
});

//group route admin ==========================================================================================================================================
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

//group route paket ==========================================================================================================================================
Route::group(['prefix' => 'paket', 'middleware' => 'auth:sanctum'], function(){
    Route::group(['prefix' => 'head'], function(){
        Route::get('/all', [PaketController::class, 'getAllHead']);
        Route::get('/find', [PaketController::class, 'findHead']);
        Route::get('/jenis', [PaketController::class, 'jenis'])->withoutMiddleware('auth:sanctum');
        Route::get('/search', [PaketController::class, 'searchHead']);
        Route::post('/store', [PaketController::class, 'storeHead']);
        Route::post('/update', [PaketController::class, 'updateHead']);
        Route::post('/delete', [PaketController::class, 'deleteHead']);
    });
    Route::group(['prefix' => 'det'], function(){
        Route::get('/all', [PaketController::class, 'getAllDet']);
        Route::get('/find', [PaketController::class, 'findDet']);
        Route::post('/store', [PaketController::class, 'storeDet']);
        Route::post('/update', [PaketController::class, 'updateDet']);
        Route::post('/delete', [PaketController::class, 'deleteDet']);

    });
});

//group route transport ==========================================================================================================================================
Route::group(['prefix' => 'transport', 'middleware' => 'auth:sanctum'], function(){
    Route::get('/all', [TransportController::class, 'getAll']);
    Route::get('/find', [TransportController::class, 'find']);
    // Route::post('/store', [TransportController::class, 'store']);
    // Route::post('/update', [TransportController::class, 'update']);
    // Route::post('/delete', [TransportController::class, 'delete']);
    Route::post('/search', [TransportController::class, 'searchByRoute']);
});

//group route objek ==========================================================================================================================================
Route::group(['prefix' => 'objek', 'middleware' => 'auth:sanctum'], function(){
    Route::get('/all', [ObjekController::class, 'getAll']);
    Route::get('/find', [ObjekController::class, 'find']);
    Route::get('/findbyloc', [ObjekController::class, 'findByLoc'])->withoutMiddleware('auth:sanctum');
    Route::get('/jenis', [ObjekController::class, 'jenis'])->withoutMiddleware('auth:sanctum');
    // Route::post('/store', [ObjekController::class, 'store']);
    // Route::post('/update', [ObjekController::class, 'update']);
    // Route::post('/delete', [ObjekController::class, 'delete']);
});

//group route reservasi ==========================================================================================================================================
Route::group(['prefix' => 'reservasi', 'middleware' => 'auth:sanctum'], function(){
    Route::group(['prefix' => 'head'], function(){
        Route::get('/all', [ReservasiController::class, 'getAllHead']);
        Route::get('/status', [ReservasiController::class, 'status'])->withoutMiddleware('auth:sanctum');
        Route::get('/find', [ReservasiController::class, 'findHead']);
        Route::post('/store', [ReservasiController::class, 'storeHead']);
        Route::post('/update', [ReservasiController::class, 'updateHead']);
        Route::post('/delete', [ReservasiController::class, 'deleteHead']);
        Route::post('/user', [ReservasiController::class, 'searchByUser']);
    });
});

//group route login ==========================================================================================================================================
Route::post('/register', [LoginController::class, 'register']);
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logoutAPI']);
// Route::get('/revokeall', [LoginController::class, 'revokeAll']);