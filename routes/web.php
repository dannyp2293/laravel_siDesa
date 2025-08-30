<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResidentController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('layouts.app');
// });
//Auth
Route::get('/', [AuthController::class, 'login']);
Route::get('/', [AuthController::class, 'login'])->name('login');
// Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
// Route::post('/logout', [AuthController::class, 'authenticate'])->name('logout');
// Route::get('/', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout']);


Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->name('dashboard')->middleware('auth');




Route::get('/resident', [ResidentController::class, 'index']);
Route::get('/resident/create', [ResidentController::class, 'create']);
Route::post('/resident', [ResidentController::class, 'store']);
Route::get('/resident/{id}/edit', [ResidentController::class, 'edit']);
Route::put('/resident/{id}', [ResidentController::class, 'update']);
Route::delete('/resident/{id}', [ResidentController::class, 'destroy']);
Route::resource('resident', ResidentController::class);
