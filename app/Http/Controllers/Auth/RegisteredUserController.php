<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\TherapistProfile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password'      => ['required', 'confirmed', Rules\Password::defaults()],
            'role'          => ['required', 'in:patient,therapist'],
            'specialty'     => ['required_if:role,therapist', 'nullable', 'string', 'max:100'],
            'qualification' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        // Create therapist profile if registering as therapist
        if ($request->role === 'therapist') {
            TherapistProfile::create([
                'user_id'       => $user->id,
                'specialty'     => $request->specialty,
                'qualification' => $request->qualification,
                'is_verified'   => false, // Requires admin verification
            ]);
        }

        event(new Registered($user));
        Auth::login($user);

        // Role-based redirect
        return match ($user->role) {
            'therapist' => redirect()->route('therapist.dashboard')
                ->with('success', 'Welcome! Your account is pending admin verification.'),
            default => redirect()->route('patient.dashboard')
                ->with('success', 'Welcome to MindCare! Start by logging your mood.'),
        };
    }
}
