<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ContactMessageController;

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
Route::post('/go-calendar', [AppointmentController::class, 'storeGuest'])->name('appointments.guest.store');

// Booking confirmation page (guest-accessible, no login needed)
Route::get('/booking-confirmation', function () {
    $appointment = session('appointment_id')
        ? \App\Models\Appointment::find(session('appointment_id'))
        : null;

    if (!$appointment) {
        return redirect('/register');
    }

    return view('booking-confirmation', compact('appointment'));
})->name('booking.confirmation');

// Patient routes (requires login)
Route::prefix('patient')->name('patient.')->middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $appointments = \App\Models\Appointment::query()
            ->where('patient_id', Auth::id())
            ->latest('appointment_date')
            ->get();

        return view('patient.dashboard', compact('appointments'));
    })->name('dashboard');
    Route::get('/appointments', [AppointmentController::class, 'patientIndex'])->name('appointments');
    Route::post('/appointments', [AppointmentController::class, 'storePatient'])->name('appointments.store');
    Route::get('/records', function () {
        $appointments = \App\Models\Appointment::query()
            ->where('patient_id', Auth::id())
            ->latest('appointment_date')
            ->get();

        return view('patient.records', compact('appointments'));
    })->name('records');
    Route::get('/video-call', fn() => view('patient.video-call'))->name('video-call');
});

// Clinic routes (requires login)
Route::prefix('clinic')->name('clinic.')->middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $clinic = Auth::user();
        $appointments = \App\Models\Appointment::query()
            ->where(function ($query) use ($clinic) {
                $query->where('clinic_id', $clinic->id)
                    ->orWhere(function ($legacyQuery) use ($clinic) {
                        $legacyQuery->whereNull('clinic_id')
                            ->where('clinic_name', $clinic->name);
                    });
            })
            ->latest('appointment_date')
            ->get();

        return view('clinic.dashboard', compact('appointments'));
    })->name('dashboard');
    Route::get('/appointments', [AppointmentController::class, 'clinicIndex'])->name('appointments');
    Route::patch('/appointments/{appointment}/approve', [AppointmentController::class, 'approve'])->name('appointments.approve');
    Route::get('/records', function () {
        $clinic = Auth::user();
        $appointments = \App\Models\Appointment::query()
            ->where(function ($query) use ($clinic) {
                $query->where('clinic_id', $clinic->id)
                    ->orWhere(function ($legacyQuery) use ($clinic) {
                        $legacyQuery->whereNull('clinic_id')
                            ->where('clinic_name', $clinic->name);
                    });
            })
            ->latest('appointment_date')
            ->get();

        return view('clinic.records', compact('appointments'));
    })->name('records');
    Route::get('/video-call', fn() => view('clinic.video-call'))->name('video-call');
});

Route::get('/story', fn() => view('story'))->name('story');
Route::get('/pricing', fn() => view('pricing'))->name('pricing');
Route::get('/contact', fn() => view('contact'))->name('contact');
Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.store');
Route::get('/learn-more', function () {
    return view('learn-more');
})->name('learn-more');
