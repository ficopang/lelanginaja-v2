<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users', [AdminController::class, 'getUserList']);
Route::post('/user/{user}', [AdminController::class, 'toggleBan']);

Route::get('/products', [AdminController::class, 'getproductList']);
Route::post('/products/delete', [AdminController::class, 'deleteProducts']);

Route::get('/reports', [AdminController::class, 'getReportList'])->name('getReportList');
Route::post('/report/{reportType}/{reportId}', [AdminController::class, 'processReport'])->name('processReport');
