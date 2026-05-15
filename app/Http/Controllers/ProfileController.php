<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();
        // Eager-load therapist profile if applicable
        if ($user->isTherapist()) {
            $user->load('therapistProfile');
        }
        return view('profile.edit', compact('user'));
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Update therapist profile fields if therapist
        if ($user->isTherapist() && $user->therapistProfile) {
            $therapistData = $request->validate([
                'bio'          => ['nullable', 'string', 'max:1000'],
                'specialty'    => ['nullable', 'string', 'max:100'],
                'hourly_rate'  => ['nullable', 'numeric', 'min:0'],
                'languages'    => ['nullable', 'string', 'max:255'],
                'is_available' => ['nullable', 'boolean'],
            ]);

            $user->therapistProfile->update($therapistData);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
