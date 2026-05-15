<?php

use App\Http\Controllers\Api\MoodLogApiController;
use App\Http\Controllers\Api\BookingApiController;
use App\Http\Controllers\Api\TherapistApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ─── Public API Routes ────────────────────────────────────────────────────────
Route::prefix('v1')->name('api.v1.')->group(function () {

    // Auth
    Route::post('/auth/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);
    Route::post('/auth/login', function (Request $request) {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!\Illuminate\Support\Facades\Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials.'], 401);
        }

        $user  = \App\Models\User::where('email', $request->email)->first();
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user]);
    });

    // Public therapist listing
    Route::get('/therapists', [TherapistApiController::class, 'index'])->name('therapists.index');
    Route::get('/therapists/{therapist}', [TherapistApiController::class, 'show'])->name('therapists.show');

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', fn(Request $req) => response()->json($req->user()));
        Route::post('/auth/logout', function (Request $req) {
            $req->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Logged out.']);
        });

        // Mood Logs
        Route::get('/mood-logs', [MoodLogApiController::class, 'index'])->name('mood.index');
        Route::post('/mood-logs', [MoodLogApiController::class, 'store'])->name('mood.store');

        // Bookings
        Route::get('/bookings', [BookingApiController::class, 'index'])->name('bookings.index');
        Route::post('/bookings', [BookingApiController::class, 'store'])->name('bookings.store');
    });
});
