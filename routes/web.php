<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [AuthController::class, 'login']);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'registerview'])->name('register.view');
Route::post('/register', [AuthController::class, 'register'])->name('register');

/*
|--------------------------------------------------------------------------
| Dashboard (akses untuk Admin & User)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware('role:Admin,User')->name('dashboard');

/*
|--------------------------------------------------------------------------
| Resident (hanya Admin yang boleh akses)
|--------------------------------------------------------------------------
*/
Route::middleware('role:Admin')->group(function () {
    Route::resource('resident', ResidentController::class);
});

/*
|--------------------------------------------------------------------------
| Account Request (Admin)
|--------------------------------------------------------------------------
*/
Route::get('/account-request', [UserController::class, 'account_request_view'])
    ->middleware('role:Admin')
    ->name('account-request.index');




Route::get('account-list', [UserController::class, 'account_list_view'])->middleware('role:Admin');



Route::post('/account-request/approval/{id}', [UserController::class, 'account_approval'])
 ->middleware('role:Admin')
->name('account-request.approval');

// Route::post('/profile/{id}', [UserController::class, 'update_profile'])
//  ->middleware('role:Admin')
// ->name('update_profile');
// Route::put('/profile/{id}', [UserController::class, 'update_profile'])
//     ->middleware('role:Admin,User')
//     ->name('profile.update');
// Route::put('/profile/{id}', [UserController::class, 'update_profile'])
//     ->middleware('role:Admin,User')
//     ->name('profile.update');
// Profile
// Route::get('/profile', [UserController::class, 'profile_view'])
//     ->middleware('role:Admin,User')
//     ->name('profile.view');

// Route::put('/profile/{id}', [UserController::class, 'update_profile'])
//     ->middleware('role:Admin,User')
//     ->name('profile.update');

// Route::get('/change-password', [UserController::class, 'change_password_view'])
//     ->middleware('role:Admin,User')
//     ->name('profile.change-password');
// routes/web.php
Route::get('/profile', [UserController::class, 'profile_view'])
    ->middleware('role:Admin,User')
    ->name('profile.view');

Route::put('/profile/{id}', [UserController::class, 'update_profile'])
    ->middleware('role:Admin,User')
    ->name('profile.update');



Route::get('/profile', [UserController::class, 'profile_view'])->middleware('role:Admin,User');

Route::get('/change-password', [UserController::class, 'change_password_view'])->middleware('role:Admin,User');

// Route::get('/change-password/{id}', [UserController::class, 'change_password'])->middleware('role:Admin,User');

Route::put('/change-password/{id}', [UserController::class, 'change_password'])
    ->middleware('role:Admin,User')
    ->name('password.update');
