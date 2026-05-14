<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\{AuthController, AppointmentController, ClinicProfileController, ContactMessageController, NotificationController};

// PUBLIC & OTHER PAGES
Route::get('/', fn() => view('landing'))->name('home');
Route::get('/get-started', fn() => view('get-started'))->name('get-started');
Route::get('/story', fn() => view('story'))->name('story');
Route::get('/pricing', [ClinicProfileController::class, 'showPricing'])->name('pricing');
Route::get('/contact', fn() => view('contact'))->name('contact');
Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.store');
Route::get('/learn-more', fn() => view('learn-more'))->name('learn-more');

// AUTH ROUTES
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/signup', fn() => view('signup'))->name('signup');
Route::post('/signup', [AuthController::class, 'register'])->name('signup.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    $clinics = \App\Models\User::where('role', 'clinic')->where('verification_status', 'approved')->orderBy('name')->get(['id', 'name', 'clinic_services']);
    return view('register', compact('clinics'));
})->name('register');
Route::post('/register', [AuthController::class, 'register']);

// OTP / PASSWORD RESET
Route::middleware('guest')->group(function() {
    Route::get('/forgot-password', fn() => view('auth.forgot-password'))->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password', fn() => view('auth.reset-password'))->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// VERIFICATION & NOTIFICATIONS
Route::middleware('auth')->group(function() {
    Route::post('/notifications/read', [NotificationController::class, 'markAllRead'])->name('notifications.read');
    Route::get('/verification-status', function () {
        $user = Auth::user();
        if ($user?->role === 'admin') return redirect()->route('admin.dashboard');
        if ($user?->verification_status === 'approved') return $user->role === 'clinic' ? redirect()->route('clinic.dashboard') : redirect()->route('patient.dashboard');
        return view('auth.verification-status', compact('user'));
    })->name('verification.status');
    Route::patch('/verification-status/resubmit', [AuthController::class, 'resubmitVerification'])->name('verification.resubmit');
});

// GUEST BOOKING
Route::post('/go-calendar', [AppointmentController::class, 'storeGuest'])->name('appointments.guest.store');
Route::get('/booking-confirmation', function () {
    $appointment = session('appointment_id') ? \App\Models\Appointment::find(session('appointment_id')) : null;
    return $appointment ? view('booking-confirmation', compact('appointment')) : redirect('/register');
})->name('booking.confirmation');
