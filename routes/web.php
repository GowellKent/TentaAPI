<?php

use App\Http\Controllers\FotoTransportController;
use App\Http\Controllers\LoginController;
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
    Route::get('/upfoto', [FotoTransportController::class, 'createForm']);
    Route::post('/upfoto', [FotoTransportController::class, 'fileUpload'])->name('fileUpload');
});

Route::get('/testchart', [LoginController::class, 'chartJs']);

// Route::get('/upFoto', [FotoTransportController::class, 'createForm']);
// Route::post('/upFoto', [FotoTransportController::class, 'fileUpload'])->name('fileUpload');
