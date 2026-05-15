<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — MindCare</title>
    <link rel="stylesheet" href="{{ asset('css/mindcare.css') }}">
</head>
<body style="background:linear-gradient(135deg,#1E4D4D,#2D6A6A,#8B7FD4);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px;">

<div style="width:100%;max-width:520px;">
    <div style="text-align:center;margin-bottom:28px;">
        <a href="{{ route('home') }}" style="font-family:'Playfair Display',serif;font-size:1.8rem;font-weight:700;color:#fff;text-decoration:none;">
            Mind<span style="color:var(--accent-light)">Care</span>
        </a>
        <p style="color:rgba(255,255,255,0.7);margin-top:6px;font-size:0.9rem;">Start your mental wellness journey</p>
    </div>

    <div class="card" style="padding:36px;">
        <h1 style="font-size:1.4rem;margin-bottom:6px;text-align:center;">Create Your Account</h1>
        <p style="color:var(--text-muted);text-align:center;font-size:0.875rem;margin-bottom:28px;">Join thousands already on their healing journey</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Role Selection --}}
            <div class="form-group">
                <label class="form-label">I am joining as</label>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <label style="cursor:pointer;">
                        <input type="radio" name="role" value="patient" {{ old('role','patient')==='patient'?'checked':'' }} style="display:none;" class="role-radio">
                        <div class="role-card {{ old('role','patient')==='patient'?'selected':'' }}" style="border:2px solid {{ old('role','patient')==='patient'?'var(--primary)':'var(--border)' }};border-radius:var(--radius-sm);padding:16px;text-align:center;transition:all 0.2s;">
                            <svg width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="margin-bottom:6px;color:var(--primary);"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <div style="font-weight:600;font-size:0.9rem;">Patient</div>
                            <div style="font-size:0.75rem;color:var(--text-muted);margin-top:2px;">I need support</div>
                        </div>
                    </label>
                    <label style="cursor:pointer;">
                        <input type="radio" name="role" value="therapist" {{ old('role')==='therapist'?'checked':'' }} style="display:none;" class="role-radio">
                        <div class="role-card {{ old('role')==='therapist'?'selected':'' }}" style="border:2px solid {{ old('role')==='therapist'?'var(--primary)':'var(--border)' }};border-radius:var(--radius-sm);padding:16px;text-align:center;transition:all 0.2s;">
                            <svg width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="margin-bottom:6px;color:var(--accent);"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            <div style="font-weight:600;font-size:0.9rem;">Therapist</div>
                            <div style="font-size:0.75rem;color:var(--text-muted);margin-top:2px;">I provide therapy</div>
                        </div>
                    </label>
                </div>
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="name" class="form-label">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control {{ $errors->has('name')?'is-invalid':'' }}" placeholder="Dr. or your full name" required autofocus>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control {{ $errors->has('email')?'is-invalid':'' }}" placeholder="you@example.com" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" name="password" class="form-control {{ $errors->has('password')?'is-invalid':'' }}" placeholder="Min 8 characters" required>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Repeat password" required>
                </div>
            </div>

            {{-- Therapist extra fields --}}
            <div id="therapistFields" style="{{ old('role')==='therapist'?'':'display:none;' }}border:1px solid var(--border-light);border-radius:var(--radius-sm);padding:16px;margin-bottom:16px;background:var(--surface);">
                <div style="font-size:0.82rem;font-weight:600;color:var(--text-muted);margin-bottom:12px;">THERAPIST DETAILS</div>
                <div class="form-group" style="margin-bottom:12px;">
                    <label class="form-label">Specialty</label>
                    <select name="specialty" class="form-control form-select">
                        <option value="">Select specialty...</option>
                        @foreach(['Anxiety & Stress','Depression','Trauma & PTSD','Relationships','Mindfulness & Wellness','Child & Adolescent','Addiction Recovery','Work & Career Stress','Grief & Loss','OCD','Bipolar Disorder','Other'] as $spec)
                            <option value="{{ $spec }}" {{ old('specialty')===$spec?'selected':'' }}>{{ $spec }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Qualification</label>
                    <input type="text" name="qualification" class="form-control" placeholder="e.g. PhD Psychology, NIMHANS" value="{{ old('qualification') }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg btn-block">Create Account</button>
        </form>

        <p style="text-align:center;margin-top:20px;font-size:0.875rem;color:var(--text-muted);">
            Already have an account? <a href="{{ route('login') }}" style="color:var(--primary);font-weight:600;">Sign in</a>
        </p>
    </div>
</div>

<script>
document.querySelectorAll('.role-radio').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.role-card').forEach(c => {
            c.style.border = '2px solid var(--border)';
            c.style.background = '';
        });
        this.nextElementSibling.style.border = '2px solid var(--primary)';
        this.nextElementSibling.style.background = 'rgba(45,106,106,0.05)';
        document.getElementById('therapistFields').style.display = this.value === 'therapist' ? 'block' : 'none';
    });
});
</script>
</body>
</html>
