<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/verifications', [AdminController::class, 'verifications'])->name('verifications');
    Route::patch('/verifications/{user}/approve', [AdminController::class, 'approve'])->name('verifications.approve');
    Route::patch('/verifications/{user}/reject', [AdminController::class, 'reject'])->name('verifications.reject');
    Route::get('/clinics', [AdminController::class, 'clinics'])->name('clinics');
    Route::get('/patients', [AdminController::class, 'patients'])->name('patients');
    Route::get('/appointments', [AdminController::class, 'appointments'])->name('appointments');
});