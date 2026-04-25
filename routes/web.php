<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // 👈 ADD THIS

// Public routes
Route::get('/', fn() => view('landing'))->name('home');
Route::get('/get-started', fn() => view('get-started'))->name('get-started');
Route::get('/login', fn() => view('login'))->name('login');
Route::get('/register', fn() => view('register'))->name('register');
Route::get('/signup', fn() => view('signup'))->name('signup');

// ✅ ADD THIS LOGOUT ROUTE
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');


// Patient routes
Route::prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', fn() => view('patient.dashboard'))->name('dashboard');
    Route::get('/appointments', fn() => view('patient.appointments'))->name('appointments');
    Route::get('/records', fn() => view('patient.records'))->name('records');
    Route::get('/video-call', fn() => view('patient.video-call'))->name('video-call');
});

// Clinic routes
Route::prefix('clinic')->name('clinic.')->group(function () {
    Route::get('/dashboard', fn() => view('clinic.dashboard'))->name('dashboard');
    Route::get('/appointments', fn() => view('clinic.appointments'))->name('appointments');
    Route::get('/records', fn() => view('clinic.records'))->name('records');
    Route::get('/video-call', fn() => view('clinic.video-call'))->name('video-call');
});