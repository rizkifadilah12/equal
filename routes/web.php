<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\penjualanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/penjualan', [penjualanController::class, 'index']);
Route::post('/penjualan', [penjualanController::class, 'create']);
Route::put('/penjualan/{id}', [PenjualanController::class, 'update']);
Route::delete('/penjualan/{id}', [PenjualanController::class, 'deleteItem']);
