<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Access Denied | MindCare</title>
    <link rel="stylesheet" href="{{ asset('css/mindcare.css') }}">
</head>
<body style="background:var(--surface);display:flex;align-items:center;justify-content:center;min-height:100vh;text-align:center;padding:24px;">
<div>
    <svg width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 16px;display:block;color:var(--danger);"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
    <h1 style="font-size:2rem;margin-bottom:10px;">Access Denied</h1>
    <p style="color:var(--text-muted);max-width:380px;margin:0 auto 28px;">You don't have permission to access this page. Please make sure you're logged in with the correct role.</p>
    <div style="display:flex;gap:12px;justify-content:center;">
        <a href="{{ url()->previous() }}" class="btn btn-ghost">← Go Back</a>
        <a href="{{ route('home') }}" class="btn btn-primary">Go to Home</a>
    </div>
</div>
</body>
</html>
