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

// Route::post('/account-request/approve/{id}', [UserController::class, 'approve'])
//     ->middleware('role:Admin')
//     ->name('account-request.approval');

// Route::post('/account-request/reject/{id}', [UserController::class, 'Reject'])
//     ->middleware('role:Admin')
//     ->name('account-request.Reject');
Route::get('account-list', [UserController::class, 'account_list_view'])->middleware('role:Admin');
// Route::get('account-list', [UserController::class, 'account_list_view'])
//     ->middleware('role:Admin')
//     ->name('account-list.index');


Route::post('/account-request/approval/{id}', [UserController::class, 'account_approval'])
 ->middleware('role:Admin')
->name('account-request.approval');
