<?php

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

// redirect to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Login Page
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Dashboard Page
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Employee Page
Route::get('/employees', function () {
    return view('employees.index');
})->name('employees');


// Department Page
Route::get('/departments', function () {
    return view('departments.index');
})->name('departments');

// attendance page
Route::get('/attendance', function () {
    return view('attendance.index');
})->name('attendance');
