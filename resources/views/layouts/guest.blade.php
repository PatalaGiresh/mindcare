<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', __('mindcare.hero_subtitle'))">
    <title>@yield('title', 'MindCare') — Mental Health & Therapy Platform</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
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
        <ul class="navbar-nav">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">{{ __('mindcare.home') }}</a></li>
            <li><a href="{{ route('therapists.index') }}" class="{{ request()->routeIs('therapists.*') ? 'active' : '' }}">{{ __('mindcare.find_therapist') }}</a></li>
            <li><a href="{{ route('resources.index') }}" class="{{ request()->routeIs('resources.*') ? 'active' : '' }}">{{ __('mindcare.resources') }}</a></li>
        </ul>
        <div class="navbar-actions">
            <form action="{{ route('locale.set') }}" method="POST" style="display:inline">
                @csrf
                <select name="locale" onchange="this.form.submit()" style="border:1px solid var(--border);border-radius:6px;padding:5px 8px;font-size:0.8rem;background:transparent;cursor:pointer;">
                    <option value="en" {{ app()->getLocale()==='en'?'selected':'' }}>🇬🇧 EN</option>
                    <option value="hi" {{ app()->getLocale()==='hi'?'selected':'' }}>🇮🇳 HI</option>
                </select>
            </form>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-sm">{{ __('mindcare.admin_panel') }}</a>
                @elseif(auth()->user()->isTherapist())
                    <a href="{{ route('therapist.dashboard') }}" class="btn btn-primary btn-sm">{{ __('mindcare.dashboard') }}</a>
                @else
                    <a href="{{ route('patient.dashboard') }}" class="btn btn-primary btn-sm">{{ __('mindcare.dashboard') }}</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" style="display:inline">@csrf<button type="submit" class="btn btn-ghost btn-sm">{{ __('mindcare.logout') }}</button></form>
            @else
                <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">{{ __('mindcare.login') }}</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">{{ __('mindcare.get_started') }}</a>
            @endauth
        </div>
    </div>
</nav>

<div style="max-width:1200px;margin:0 auto;padding:0 24px;">
    @if(session('success'))<div class="alert alert-success mt-16">✓ {{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-error mt-16">✕ {{ session('error') }}</div>@endif
</div>

@yield('content')

<footer class="footer">
    <div class="container">
        <div class="grid-4" style="gap:40px;">
            <div>
                <div class="footer-logo">Mind<span style="color:var(--accent-light)">Care</span></div>
                <p style="font-size:0.875rem;line-height:1.7;max-width:220px;">{{ __('mindcare.footer_desc') }}</p>
            </div>
            <div>
                <p style="color:#fff;font-weight:600;margin-bottom:14px;font-size:0.875rem;">{{ __('mindcare.platform') }}</p>
                <ul class="footer-links">
                    <li><a href="{{ route('therapists.index') }}">{{ __('mindcare.find_therapist') }}</a></li>
                    <li><a href="{{ route('resources.index') }}">{{ __('mindcare.resources') }}</a></li>
                </ul>
            </div>
            <div>
                <p style="color:#fff;font-weight:600;margin-bottom:14px;font-size:0.875rem;">{{ __('mindcare.support') }}</p>
                <ul class="footer-links">
                    <li><a href="#">{{ __('mindcare.help_center') }}</a></li>
                    <li><a href="#">{{ __('mindcare.privacy_policy') }}</a></li>
                    <li><a href="#">{{ __('mindcare.terms_of_service') }}</a></li>
                </ul>
            </div>
            <div>
                <p style="color:#fff;font-weight:600;margin-bottom:14px;font-size:0.875rem;">{{ __('mindcare.crisis_support') }}</p>
                <p style="font-size:0.82rem;line-height:1.8;">iCall: <strong style="color:#fff;">9152987821</strong><br>Vandrevala: <strong style="color:#fff;">1860-2662-345</strong></p>
            </div>
        </div>
        <div class="footer-bottom"><span>© {{ date('Y') }} MindCare. {{ __('mindcare.all_rights_reserved') }}</span><span>{{ __('mindcare.made_with_heart') }}</span></div>
    </div>
</footer>
@stack('scripts')
</body>
</html>
