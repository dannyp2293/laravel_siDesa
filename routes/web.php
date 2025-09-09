<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResidentController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('layouts.app');
// });
//Auth





/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/





Route::get('/', [AuthController::class, 'login']);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/register', [AuthController::class, 'registerview']);
Route::post('/register', [AuthController::class, 'register']);

/*
|--------------------------------------------------------------------------
| Dashboard (akses untuk Admin & User)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware('role:Admin,User');

/*
|--------------------------------------------------------------------------
| Resident (hanya Admin yang boleh akses)
|--------------------------------------------------------------------------
*/
Route::middleware('role:Admin')->group(function () {
    Route::resource('resident', ResidentController::class);
});

Route::resource('resident', ResidentController::class)
     ->middleware('role:Admin');

Route::get('/resident', [ResidentController::class, 'index'])->middleware('role:Admin');
Route::get('/resident/create', [ResidentController::class, 'create'])->middleware('role:Admin');
Route::post('/resident', [ResidentController::class, 'store'])->middleware('role:Admin');
Route::get('/resident/{id}/edit', [ResidentController::class, 'edit'])->middleware('role:Admin');
Route::put('/resident/{id}', [ResidentController::class, 'update'])->middleware('role:Admin');
Route::delete('/resident/{id}', [ResidentController::class, 'destroy'])->middleware('role:Admin');


