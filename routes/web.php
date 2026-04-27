<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\AuthController;

// Public routes
Route::get('/', fn() => view('landing'))->name('home');
Route::get('/get-started', fn() => view('get-started'))->name('get-started');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Signup routes
Route::get('/signup', fn() => view('signup'))->name('signup');
Route::post('/signup', [AuthController::class, 'register'])->name('signup.post');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// GUEST APPOINTMENT BOOKING — no account required
Route::post('/go-calendar', function (Request $request) {
    session([
        'appointment' => $request->all()
    ]);
    return redirect('/booking-confirmation');
});

// Booking confirmation page (guest-accessible, no login needed)
Route::get('/booking-confirmation', function () {
    if (!session('appointment')) {
        return redirect('/register');
    }
    return view('booking-confirmation');
})->name('booking.confirmation');

// Patient routes (requires login)
Route::prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', fn() => view('patient.dashboard'))->name('dashboard');
    Route::get('/appointments', fn() => view('patient.appointments'))->name('appointments');
    Route::get('/records', fn() => view('patient.records'))->name('records');
    Route::get('/video-call', fn() => view('patient.video-call'))->name('video-call');
});

// Clinic routes (requires login)
Route::prefix('clinic')->name('clinic.')->group(function () {
    Route::get('/dashboard', fn() => view('clinic.dashboard'))->name('dashboard');
    Route::get('/appointments', fn() => view('clinic.appointments'))->name('appointments');
    Route::get('/records', fn() => view('clinic.records'))->name('records');
    Route::get('/video-call', fn() => view('clinic.video-call'))->name('video-call');
});

Route::get('/services', fn() => view('services'))->name('services');
Route::get('/pricing', fn() => view('pricing'))->name('pricing');
Route::get('/contact', fn() => view('contact'))->name('contact');
Route::get('/learn-more', function () {
    return view('learn-more');
})->name('learn-more');