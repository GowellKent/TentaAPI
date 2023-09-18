<?php

use App\Http\Controllers\FotoTransportController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ObjekController;
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

    Route::get('/dashboard',function(){
        return view('dashboard', ['title'=>'Dashboard']);
    });

    //group function transportasi ========================================================================================================
    Route::group(['prefix' => 'transportasi'], function(){
        Route::get('/index',[TransportController::class, 'index']);
        Route::get('/detail',[TransportController::class, 'detail']);
        Route::post('/update',[TransportController::class, 'updateWeb']);
        Route::post('/delete',[TransportController::class, 'deleteWeb']);
        Route::get('/create', function(){
            return view('transportasi.create', ['title'=>'Create Data Transportasi']);
        });
        Route::post('/create', [TransportController::class, 'create'])->middleware('auth');
    });
    
    //group function customer ========================================================================================================
    Route::group(['prefix' => 'customer'], function(){
        Route::get('/index', [LoginController::class, 'customer']);
    });

    //group function objek  ========================================================================================================        
    Route::group(['prefix' => 'objek'], function(){
        Route::get('/index', [ObjekController::class, 'index']);
        Route::get('/detail', [ObjekController::class, 'detail']);
        Route::get('/create', function(){
            return view('objek.create', ['title'=>'Create Objek Wisata']);
        });
        Route::post('/create', [ObjekController::class, 'create']);
        Route::post('/update', [ObjekController::class, 'objekUpdate']);
        Route::post('/delete', [ObjekController::class, 'objekDelete']);
    });
});

Route::get('/testchart', [LoginController::class, 'chartJs']);


// Route::get('/upFoto', [FotoTransportController::class, 'createForm']);
// Route::post('/upFoto', [FotoTransportController::class, 'fileUpload'])->name('fileUpload');
