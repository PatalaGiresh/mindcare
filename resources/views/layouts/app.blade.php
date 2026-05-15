<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — MindCare</title>
    <link rel="stylesheet" href="{{ asset('css/mindcare.css') }}">
    @stack('styles')
</head>
<body>

<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ route('home') }}" class="navbar-brand">
            <svg width="28" height="28" viewBox="0 0 28 28" fill="none"><circle cx="14" cy="14" r="14" fill="#2D6A6A"/><path d="M14 7c-3.866 0-7 3.134-7 7 0 2.21 1.03 4.18 2.636 5.468L14 22l4.364-2.532A6.975 6.975 0 0021 14c0-3.866-3.134-7-7-7z" fill="white" opacity="0.9"/><circle cx="14" cy="14" r="2.5" fill="#8B7FD4"/></svg>
            Mind<span class="brand-dot">Care</span>
        </a>
        <div class="navbar-actions">
            <span style="font-size:0.875rem;color:var(--text-muted)">Welcome, <strong style="color:var(--text-primary)">{{ auth()->user()->name }}</strong></span>
            <form action="{{ route('locale.set') }}" method="POST" style="display:inline">
                @csrf
                <select name="locale" onchange="this.form.submit()" style="border:1px solid var(--border);border-radius:6px;padding:5px 8px;font-size:0.8rem;background:transparent;cursor:pointer;">
                    <option value="en" {{ app()->getLocale()==='en'?'selected':'' }}>EN</option>
                    <option value="hi" {{ app()->getLocale()==='hi'?'selected':'' }}>HI</option>
                </select>
            </form>
            <form action="{{ route('logout') }}" method="POST" style="display:inline">@csrf<button type="submit" class="btn btn-ghost btn-sm">Logout</button></form>
        </div>
    </div>
</nav>

<div class="dashboard-wrapper">
    <aside class="sidebar">
        {{-- User info --}}
        <div style="padding:0 16px 20px;border-bottom:1px solid var(--border-light);margin-bottom:16px;">
            <div class="d-flex align-center gap-12">
                <div class="therapist-avatar" style="width:44px;height:44px;font-size:1rem;">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
                <div>
                    <div style="font-weight:600;font-size:0.875rem;line-height:1.2;">{{ auth()->user()->name }}</div>
                    <div style="font-size:0.75rem;color:var(--text-muted);text-transform:capitalize;">{{ auth()->user()->role }}</div>
                </div>
            </div>
            @if($needsVerification)<div class="alert alert-warning mt-12" style="font-size:0.78rem;padding:8px 12px;">Pending admin verification</div>@endif
        </div>

        @if(auth()->user()->isPatient())
        <div class="sidebar-section">
            <div class="sidebar-label">Patient Menu</div>
            <a href="{{ route('patient.dashboard') }}" class="sidebar-link {{ request()->routeIs('patient.dashboard')?'active':'' }}">
                <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="{{ route('patient.mood.index') }}" class="sidebar-link {{ request()->routeIs('patient.mood.*')?'active':'' }}">
                <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Mood Tracker
            </a>
            <a href="{{ route('patient.bookings.index') }}" class="sidebar-link {{ request()->routeIs('patient.bookings.*')?'active':'' }}">
                <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                My Bookings
            </a>
            <a href="{{ route('messages.index') }}" class="sidebar-link {{ request()->routeIs('messages.*')?'active':'' }}">
                <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                Messages
                @if($globalUnreadCount>0)<span class="sidebar-badge">{{ $globalUnreadCount }}</span>@endif
            </a>
            <a href="{{ route('therapists.index') }}" class="sidebar-link">
                <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Find Therapists
            </a>
            <a href="{{ route('resources.index') }}" class="sidebar-link">
                <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                Resources
            </a>
        </div>

        @elseif(auth()->user()->isTherapist())
        <div class="sidebar-section">
            <div class="sidebar-label">Therapist Menu</div>
            <a href="{{ route('therapist.dashboard') }}" class="sidebar-link {{ request()->routeIs('therapist.dashboard')?'active':'' }}">
                <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="{{ route('therapist.sessions.index') }}" class="sidebar-link {{ request()->routeIs('therapist.sessions.*')?'active':'' }}">
                <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                My Sessions
            </a>
            <a href="{{ route('messages.index') }}" class="sidebar-link {{ request()->routeIs('messages.*')?'active':'' }}">
                <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                Messages
                @if($globalUnreadCount>0)<span class="sidebar-badge">{{ $globalUnreadCount }}</span>@endif
            </a>
            <a href="{{ route('resources.index') }}" class="sidebar-link">
                <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                Resources
            </a>
        </div>

        @elseif(auth()->user()->isAdmin())
        <div class="sidebar-section">
            <div class="sidebar-label">Admin Menu</div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard')?'active':'' }}">
                <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1" stroke-linecap="round"/><rect x="14" y="3" width="7" height="7" rx="1" stroke-linecap="round"/><rect x="3" y="14" width="7" height="7" rx="1" stroke-linecap="round"/><rect x="14" y="14" width="7" height="7" rx="1" stroke-linecap="round"/></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*')?'active':'' }}">
                <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Users
            </a>
            <a href="{{ route('resources.index') }}" class="sidebar-link">
                <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                Resources
            </a>
        </div>
        @endif

        <div class="sidebar-section" style="margin-top:8px;">
            <div class="sidebar-label">Account</div>
            <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*')?'active':'' }}">
                <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Profile Settings
            </a>
        </div>
    </aside>

    <main class="dashboard-main">
        @if(session('success'))<div class="alert alert-success mb-24">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-error mb-24">{{ session('error') }}</div>@endif
        @yield('content')
    </main>
</div>

@stack('scripts')
</body>
</html>
