<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Page Not Found | MindCare</title>
    <link rel="stylesheet" href="{{ asset('css/mindcare.css') }}">
</head>
<body style="background:var(--surface);display:flex;align-items:center;justify-content:center;min-height:100vh;text-align:center;padding:24px;">
<div>
    <svg width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 16px;display:block;color:var(--primary);"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35" stroke-linecap="round"/></svg>
    <h1 style="font-size:2rem;margin-bottom:10px;">Page Not Found</h1>
    <p style="color:var(--text-muted);max-width:380px;margin:0 auto 28px;">The page you're looking for doesn't exist or may have been moved. Let's get you back on track.</p>
    <div style="display:flex;gap:12px;justify-content:center;">
        <a href="{{ url()->previous() }}" class="btn btn-ghost">← Go Back</a>
        <a href="{{ route('home') }}" class="btn btn-primary">Go to Home</a>
    </div>
</div>
</body>
</html>
