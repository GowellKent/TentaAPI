<?php

use App\Http\Controllers\FotoTransportController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TransportController;
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

Route::get('/home', function () {
    return view('welcome');
});


Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::get('/login', [LoginController::class, 'index'])->middleware('guest');
Route::post('/login', [LoginController::class, 'authweb']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function(){
    // Route::get('/upfoto', [FotoTransportController::class, 'createForm']);
    // Route::post('/upfoto', [FotoTransportController::class, 'fileUpload'])->name('fileUpload');
    Route::group(['prefix' => 'transportasi'], function(){
        Route::get('/index',[TransportController::class, 'index']);
        Route::get('/detail',[TransportController::class, 'detail']);
        Route::post('/update',[TransportController::class, 'updateWeb']);
        Route::get('/create', function(){
            return view('transportasi.create', ['title'=>'Create Data Transportasi']);
        })->middleware('auth');
        Route::post('/create', [TransportController::class, 'create'])->middleware('auth');
    });

    Route::group(['prefix' => 'customer'], function(){
        Route::get('/index', [LoginController::class, 'customer']);
    });
});

Route::get('/testchart', [LoginController::class, 'chartJs']);

// Route::get('/upFoto', [FotoTransportController::class, 'createForm']);
// Route::post('/upFoto', [FotoTransportController::class, 'fileUpload'])->name('fileUpload');
