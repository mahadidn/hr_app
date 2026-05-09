<?php

use App\Http\Controllers\AuthController;
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

// Redirect Default
Route::redirect('/', '/login');

// ==========================================
// GUEST AREA
// ==========================================
Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.submit');
});


// ==========================================
// AUTHENTICATED AREA (Must Login)
// ==========================================
Route::middleware('auth')->group(function () {

    // Auth Actions
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Master Data
    Route::view('/employees', 'employees.index')->name('employees');
    Route::view('/departments', 'departments.index')->name('departments');

    // Transactions / Operations
    Route::view('/attendance', 'attendance.index')->name('attendance');
});
