<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ClinicPatientController;
use App\Http\Controllers\ClinicProfileController;
use App\Http\Controllers\VideoConsultationController;

Route::prefix('clinic')->name('clinic.')->middleware(['auth', 'role:clinic', 'verified.user:clinic'])->group(function () {
    Route::get('/dashboard', function () {
        $clinic = Auth::user();
        $appointments = \App\Models\Appointment::query()
            ->with('videoConsultation')
            ->forClinic($clinic)
            ->latestBooked()->get();
        return view('clinic.dashboard', compact('appointments'));
    })->name('dashboard');
    
    Route::get('/appointments', [AppointmentController::class, 'clinicIndex'])->name('appointments');
    Route::patch('/appointments/{appointment}/approve', [AppointmentController::class, 'approve'])->name('appointments.approve');
    Route::patch('/appointments/{appointment}/decline', [AppointmentController::class, 'decline'])->name('appointments.decline');
    
    Route::get('/records', [ClinicPatientController::class, 'index'])->name('records');
    Route::get('/records/{patientKey}', [ClinicPatientController::class, 'show'])->name('records.history');
    
    Route::get('/profile', [ClinicProfileController::class, 'edit'])->name('profile');
    Route::patch('/profile', [ClinicProfileController::class, 'update'])->name('profile.update');
    Route::get('/video-call/{appointment?}', [VideoConsultationController::class, 'clinic'])->name('video-call');
    Route::post('/video-call/{appointment}/started', [VideoConsultationController::class, 'markClinicStarted'])->name('video-call.started');
    Route::post('/video-call/{appointment}/ended', [VideoConsultationController::class, 'markClinicEnded'])->name('video-call.ended.store');
    Route::get('/video-call-ended', [VideoConsultationController::class, 'clinicEnded'])->name('video-call.ended');
});
