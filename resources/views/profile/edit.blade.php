@extends('layouts.app')
@section('title', 'Profile Settings')
@section('content')
<h1 style="font-size:1.6rem;margin-bottom:4px;">Profile Settings</h1>
<p style="color:var(--text-muted);margin-bottom:32px;">Manage your account information, password, and preferences.</p>

<div style="max-width:660px;">
    {{-- Update Profile Information --}}
    <div class="card mb-24">
        <div class="card-header"><h2 style="font-size:1.05rem;">Account Information</h2></div>
        <div class="card-body">
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf @method('PATCH')
                <div class="form-group">
                    <label class="form-label" for="name">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control {{ $errors->has('name')?'is-invalid':'' }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control {{ $errors->has('email')?'is-invalid':'' }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                @if($user->isTherapist() && $user->therapistProfile)
                <div style="border-top:1px solid var(--border-light);padding-top:16px;margin-top:8px;">
                    <div style="font-size:0.78rem;font-weight:600;color:var(--text-muted);margin-bottom:12px;">THERAPIST DETAILS</div>
                    <div class="form-group">
                        <label class="form-label">Bio</label>
                        <textarea name="bio" class="form-control" rows="3">{{ old('bio', $user->therapistProfile->bio) }}</textarea>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                        <div class="form-group">
                            <label class="form-label">Specialty</label>
                            <input type="text" name="specialty" class="form-control" value="{{ old('specialty', $user->therapistProfile->specialty) }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Hourly Rate (₹)</label>
                            <input type="number" name="hourly_rate" class="form-control" value="{{ old('hourly_rate', $user->therapistProfile->hourly_rate) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Languages</label>
                        <input type="text" name="languages" class="form-control" value="{{ old('languages', $user->therapistProfile->languages) }}" placeholder="English, Hindi">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Available for bookings</label>
                        <select name="is_available" class="form-control form-select">
                            <option value="1" {{ $user->therapistProfile->is_available ? 'selected' : '' }}>Yes — accepting new patients</option>
                            <option value="0" {{ !$user->therapistProfile->is_available ? 'selected' : '' }}>No — not accepting now</option>
                        </select>
                    </div>
                </div>
                @endif

                <button type="submit" class="btn btn-primary">Save Changes</button>
                @if(session('status') === 'profile-updated')
                    <span style="color:var(--success);font-size:0.85rem;margin-left:12px;">Saved!</span>
                @endif
            </form>
        </div>
    </div>

    {{-- Update Password --}}
    <div class="card mb-24">
        <div class="card-header"><h2 style="font-size:1.05rem;">Change Password</h2></div>
        <div class="card-body">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf @method('PUT')
                <div class="form-group">
                    <label class="form-label" for="current_password">Current Password</label>
                    <input id="current_password" type="password" name="current_password" class="form-control {{ $errors->updatePassword->has('current_password')?'is-invalid':'' }}" autocomplete="current-password">
                    @if($errors->updatePassword->has('current_password'))<div class="invalid-feedback">{{ $errors->updatePassword->first('current_password') }}</div>@endif
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                    <div class="form-group">
                        <label class="form-label" for="password">New Password</label>
                        <input id="password" type="password" name="password" class="form-control {{ $errors->updatePassword->has('password')?'is-invalid':'' }}" autocomplete="new-password">
                        @if($errors->updatePassword->has('password'))<div class="invalid-feedback">{{ $errors->updatePassword->first('password') }}</div>@endif
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Confirm New Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update Password</button>
                @if(session('status') === 'password-updated')
                    <span style="color:var(--success);font-size:0.85rem;margin-left:12px;">Password changed!</span>
                @endif
            </form>
        </div>
    </div>

    {{-- Delete Account --}}
    <div class="card" style="border-color:rgba(192,80,74,0.3);">
        <div class="card-header" style="background:rgba(192,80,74,0.04);"><h2 style="font-size:1.05rem;color:var(--danger);">Danger Zone</h2></div>
        <div class="card-body">
            <p style="color:var(--text-muted);font-size:0.875rem;margin-bottom:16px;">Once you delete your account, all of your data — including mood logs, bookings, and messages — will be permanently removed.</p>
            <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you absolutely sure? This cannot be undone.')">
                @csrf @method('DELETE')
                <div class="form-group">
                    <label class="form-label" for="delete_password">Confirm your password to delete</label>
                    <input id="delete_password" type="password" name="password" class="form-control {{ $errors->userDeletion->has('password')?'is-invalid':'' }}" placeholder="Enter your current password" required>
                    @if($errors->userDeletion->has('password'))<div class="invalid-feedback">{{ $errors->userDeletion->first('password') }}</div>@endif
                </div>
                <button type="submit" class="btn btn-danger">Delete My Account</button>
            </form>
        </div>
    </div>
</div>
@endsection
