<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\VideoConsultationController;

// PUBLIC ROUTES
Route::get('/', fn() => view('landing'))->name('home');
Route::get('/get-started', fn() => view('get-started'))->name('get-started');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', function () {
    $clinics = \App\Models\User::query()
        ->where('role', 'clinic')
        ->orderBy('name')
        ->get(['id', 'name', 'clinic_services']);

    return view('register', compact('clinics'));
})->name('register');
Route::post('/register', [AuthController::class, 'register']);

// ==============================================================================
// OTP PASSWORD RESET ROUTES (UPDATED TO OTP FLOW)
// ==============================================================================

// 1. LOADS THE FORGOT PASSWORD PAGE (WHERE USER ENTERS EMAIL)
Route::get('/forgot-password', function() {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

// 2. TRIGGER SENDING THE 6-DIGIT OTP CODE TO GMAIL
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->middleware('guest')->name('password.email');

// 3. LOADS THE PAGE TO ENTER THE OTP CODE AND NEW PASSWORD
Route::get('/reset-password', function() {
    return view('auth.reset-password');
})->middleware('guest')->name('password.reset');

// 4. SAVES THE NEW PASSWORD AFTER VERIFYING THE OTP CODE
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware('guest')->name('password.update');

// ==============================================================================

// SIGNUP ROUTES
Route::get('/signup', fn() => view('signup'))->name('signup');
Route::post('/signup', [AuthController::class, 'register'])->name('signup.post');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

Route::post('/notifications/read', [NotificationController::class, 'markAllRead'])
    ->middleware('auth')
    ->name('notifications.read');

// GUEST APPOINTMENT BOOKING
Route::post('/go-calendar', [AppointmentController::class, 'storeGuest'])->name('appointments.guest.store');

// BOOKING CONFIRMATION
Route::get('/booking-confirmation', function () {
    $appointment = session('appointment_id')
        ? \App\Models\Appointment::find(session('appointment_id'))
        : null;

    if (!$appointment) {
        return redirect('/register');
    }

    return view('booking-confirmation', compact('appointment'));
})->name('booking.confirmation');

// PATIENT ROUTES (PROTECTED BY AUTH)
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
    Route::get('/video-call/{appointment?}', [VideoConsultationController::class, 'patient'])->name('video-call');
});

// CLINIC ROUTES (PROTECTED BY AUTH)
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
    Route::patch('/appointments/{appointment}/decline', [AppointmentController::class, 'decline'])->name('appointments.decline');
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
    Route::get('/video-call/{appointment?}', [VideoConsultationController::class, 'clinic'])->name('video-call');
});

// OTHER PUBLIC PAGES
Route::get('/story', fn() => view('story'))->name('story');
Route::get('/pricing', function () {
    $registeredClinics = \App\Models\User::query()
        ->where('role', 'clinic')
        ->orderBy('name')
        ->get();

    return view('pricing', compact('registeredClinics'));
})->name('pricing');
Route::get('/contact', fn() => view('contact'))->name('contact');
Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.store');
Route::get('/learn-more', function () {
    return view('learn-more');
})->name('learn-more');
