<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\VideoConsultationController;

Route::prefix('patient')->name('patient.')->middleware(['auth', 'role:patient', 'verified.user:patient'])->group(function () {
    Route::get('/dashboard', function () {
        $appointments = \App\Models\Appointment::with('videoConsultation')->where('patient_id', Auth::id())->latestBooked()->get();
        return view('patient.dashboard', compact('appointments'));
    })->name('dashboard');
    
    Route::get('/appointments', [AppointmentController::class, 'patientIndex'])->name('appointments');
    Route::post('/appointments', [AppointmentController::class, 'storePatient'])->name('appointments.store');
    
    Route::get('/records', function () {
        $appointments = \App\Models\Appointment::with('videoConsultation')->where('patient_id', Auth::id())->latestBooked()->get();
        return view('patient.records', compact('appointments'));
    })->name('records');
    
    Route::get('/video-call/{appointment?}', [VideoConsultationController::class, 'patient'])->name('video-call');
    Route::post('/video-call/{appointment}/ended', [VideoConsultationController::class, 'markPatientEnded'])->name('video-call.ended.store');
    Route::get('/video-call-ended', [VideoConsultationController::class, 'patientEnded'])->name('video-call.ended');
});
