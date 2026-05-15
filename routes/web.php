<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TherapistController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\PatientDashboardController;
use App\Http\Controllers\MoodLogController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\TherapistDashboardController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SessionNoteController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ─── Guest Routes ────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/locale', [HomeController::class, 'setLocale'])->name('locale.set');

Route::get('/therapists', [TherapistController::class, 'index'])->name('therapists.index');
Route::get('/therapists/{therapist}', [TherapistController::class, 'show'])->name('therapists.show');

Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
Route::get('/resources/{resource:slug}', [ResourceController::class, 'show'])->name('resources.show');

// ─── Auth Routes (Breeze) ─────────────────────────────────────────────────────
require __DIR__.'/auth.php';

// ─── Authenticated Routes ─────────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    // Profile (Breeze default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ─── Patient Routes ───────────────────────────────────────────────────────
    Route::middleware(['role:patient'])->prefix('patient')->name('patient.')->group(function () {
        Route::get('/dashboard', [PatientDashboardController::class, 'index'])->name('dashboard');

        // Mood Logs (full resource)
        Route::resource('mood', MoodLogController::class)->names([
            'index'   => 'mood.index',
            'create'  => 'mood.create',
            'store'   => 'mood.store',
            'show'    => 'mood.show',
            'edit'    => 'mood.edit',
            'update'  => 'mood.update',
            'destroy' => 'mood.destroy',
        ]);

        // Bookings
        Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
        Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
        Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
        Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
    });

    // ─── Messages (shared by patient & therapist) ─────────────────────────────
    Route::middleware(['role:patient,therapist'])->group(function () {
        Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
        Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
        Route::get('/resources/create', [ResourceController::class, 'create'])->name('resources.create');
        Route::post('/resources', [ResourceController::class, 'store'])->name('resources.store');
    });

    // ─── Therapist Routes ─────────────────────────────────────────────────────
    Route::middleware(['role:therapist'])->prefix('therapist')->name('therapist.')->group(function () {
        Route::get('/dashboard', [TherapistDashboardController::class, 'index'])->name('dashboard');

        // Sessions
        Route::get('/sessions', [SessionController::class, 'index'])->name('sessions.index');
        Route::get('/sessions/{session}', [SessionController::class, 'show'])->name('sessions.show');
        Route::patch('/sessions/{session}/status', [SessionController::class, 'updateStatus'])->name('sessions.status');
        Route::patch('/sessions/{session}/meeting-link', [SessionController::class, 'updateMeetingLink'])->name('sessions.meeting-link');

        // Session Notes
        Route::post('/sessions/{session}/notes', [SessionNoteController::class, 'store'])->name('sessions.notes.store');
    });

    // ─── Admin Routes ─────────────────────────────────────────────────────────
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // User Management
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
        Route::patch('/users/{user}/role', [AdminUserController::class, 'toggleRole'])->name('users.role');
        Route::post('/users/{user}/verify-therapist', [AdminUserController::class, 'verifyTherapist'])->name('users.verify-therapist');
    });

    // ─── Redirect after login based on role ──────────────────────────────────
    Route::get('/dashboard', function () {
        return match (auth()->user()->role) {
            'admin'     => redirect()->route('admin.dashboard'),
            'therapist' => redirect()->route('therapist.dashboard'),
            default     => redirect()->route('patient.dashboard'),
        };
    })->name('dashboard');
});
