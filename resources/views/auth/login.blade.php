<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — MindCare</title>
    <link rel="stylesheet" href="{{ asset('css/mindcare.css') }}">
</head>
<body style="background:linear-gradient(135deg,#1E4D4D,#2D6A6A,#8B7FD4);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px;">
<div style="width:100%;max-width:440px;">
    <div style="text-align:center;margin-bottom:28px;">
        <a href="{{ route('home') }}" style="font-family:'Playfair Display',serif;font-size:1.8rem;font-weight:700;color:#fff;text-decoration:none;">Mind<span style="color:#B3AAED">Care</span></a>
        <p style="color:rgba(255,255,255,0.7);margin-top:6px;font-size:0.9rem;">Welcome back</p>
    </div>
    <div class="card" style="padding:36px;">
        <h1 style="font-size:1.4rem;margin-bottom:6px;text-align:center;">Sign In</h1>
        <p style="color:var(--text-muted);text-align:center;font-size:0.875rem;margin-bottom:28px;">Continue your healing journey</p>

        @if(session('status'))
            <div class="alert alert-success mb-16">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control {{ $errors->has('email')?'is-invalid':'' }}" placeholder="you@example.com" required autofocus>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="password" class="form-label">
                    Password
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="float:right;font-weight:400;color:var(--primary);font-size:0.82rem;">Forgot password?</a>
                    @endif
                </label>
                <input id="password" type="password" name="password" class="form-control {{ $errors->has('password')?'is-invalid':'' }}" placeholder="Your password" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-check">
                    <input type="checkbox" name="remember" class="form-check-input">
                    <span style="font-size:0.875rem;color:var(--text-secondary);">Remember me for 30 days</span>
                </label>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">Sign In</button>
        </form>

        <div style="margin-top:20px;padding-top:20px;border-top:1px solid var(--border-light);text-align:center;">
            <p style="font-size:0.875rem;color:var(--text-muted);margin-bottom:16px;">Don't have an account? <a href="{{ route('register') }}" style="color:var(--primary);font-weight:600;">Create one free</a></p>
            <div style="font-size:0.78rem;color:var(--text-muted);background:var(--surface);border-radius:var(--radius-sm);padding:12px;">
                <strong>Demo Accounts:</strong><br>
                Admin: admin@mindcare.com / password<br>
                Patient: rahul@example.com / password<br>
                Therapist: drpriyasharma@mindcare.com / password
            </div>
        </div>
    </div>
</div>
</body>
</html>
