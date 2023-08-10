<?php

use App\Http\Controllers\FotoTransportController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProvKotaController;
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
    Route::post('/delFoto', [FotoTransportController::class, 'delFoto']);
    Route::get('/findFoto', [FotoTransportController::class, 'findFoto']);
});

Route::post('/register', [LoginController::class, 'register']);
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logoutAPI']);
Route::get('/revokeall', [LoginController::class, 'revokeAll']);