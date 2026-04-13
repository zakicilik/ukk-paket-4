<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BorrowingController as AdminBorrowingController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\BorrowingController as UserBorrowingController;

// AUTH
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'store'])->name('register.post');
});

// LOGOUT → HARUS POST
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ADMIN
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('books', BookController::class);
        Route::resource('users', UserController::class);
        Route::resource('borrowings', AdminBorrowingController::class);
        Route::post('/borrowings/{id}/approve', [AdminBorrowingController::class, 'approve'])
            ->name('borrowings.approve');
        
    });

// USER
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/books', [UserBorrowingController::class, 'books'])->name('books');
    Route::get('/borrowings', [UserBorrowingController::class, 'index'])->name('borrowings');
    Route::post('/pinjam/{id}', [UserBorrowingController::class, 'pinjam'])->name('pinjam');
    Route::post('/kembali/{id}', [UserBorrowingController::class, 'kembali'])->name('kembali');
});

// DEFAULT
Route::get('/', function () {
    return view('welcome');
})->name('welcome');