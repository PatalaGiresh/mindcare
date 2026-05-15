@extends('layouts.guest')
@section('title', 'Find a Therapist')
@section('content')
<div style="background:var(--card);border-bottom:1px solid var(--border-light);padding:40px 0;">
    <div class="container">
        <h1 style="font-size:2rem;margin-bottom:8px;">Find Your Therapist</h1>
        <p style="color:var(--text-muted);">Connect with certified mental health professionals</p>
        <form method="GET" action="{{ route('therapists.index') }}" style="margin-top:24px;">
            <div style="display:flex;gap:12px;flex-wrap:wrap;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or specialty..." class="form-control" style="max-width:280px;">
                <select name="specialty" class="form-control form-select" style="max-width:220px;">
                    <option value="">All Specialties</option>
                    @foreach($specialties as $s)<option value="{{ $s }}" {{ request('specialty')===$s?'selected':'' }}>{{ $s }}</option>@endforeach
                </select>
                <select name="max_rate" class="form-control form-select" style="max-width:180px;">
                    <option value="">Any Budget</option>
                    <option value="500" {{ request('max_rate')==='500'?'selected':'' }}>Under ₹500/hr</option>
                    <option value="750" {{ request('max_rate')==='750'?'selected':'' }}>Under ₹750/hr</option>
                    <option value="1000" {{ request('max_rate')==='1000'?'selected':'' }}>Under ₹1000/hr</option>
                </select>
                <button type="submit" class="btn btn-primary">Search</button>
                @if(request()->hasAny(['search','specialty','max_rate']))<a href="{{ route('therapists.index') }}" class="btn btn-ghost">Clear</a>@endif
            </div>
        </form>
    </div>
</div>
<div class="section">
    <div class="container">
        @if($therapists->count() > 0)
        <div class="grid-3">
            @foreach($therapists as $therapist)
            <div class="therapist-card">
                <div class="d-flex align-center gap-16 mb-16">
                    <div class="therapist-avatar">{{ strtoupper(substr($therapist->user->name,0,1)) }}</div>
                    <div>
                        <div style="font-weight:700;color:var(--text-primary);">{{ $therapist->user->name }}</div>
                        <div class="therapist-specialty mt-4">{{ $therapist->specialty }}</div>
                    </div>
                </div>
                <div class="d-flex gap-16 mb-12">
                    <span class="rating-stars">★ {{ number_format($therapist->rating,1) }}</span>
                    <span style="font-size:0.8rem;color:var(--text-muted);">{{ $therapist->experience_years }} yrs</span>
                    <span style="font-size:0.8rem;color:var(--text-muted);">{{ $therapist->total_sessions }} sessions</span>
                </div>
                <p style="font-size:0.875rem;color:var(--text-muted);margin-bottom:18px;">{{ Str::limit($therapist->bio,120) }}</p>
                <div class="d-flex justify-between align-center">
                    <div>
                        <div style="font-weight:700;font-size:1.1rem;color:var(--primary);">₹{{ number_format($therapist->hourly_rate) }}/hr</div>
                        @if($therapist->is_available)<span class="badge badge-success" style="font-size:0.72rem;">✓ Available</span>@endif
                    </div>
                    <a href="{{ route('therapists.show',$therapist) }}" class="btn btn-primary btn-sm">View & Book</a>
                </div>
            </div>
            @endforeach
        </div>
        {{ $therapists->withQueryString()->links() }}
        @else
        <div style="text-align:center;padding:80px 0;">
            <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 16px;display:block;color:var(--border);"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35" stroke-linecap="round"/></svg>
            <h3>No therapists found</h3>
            <a href="{{ route('therapists.index') }}" class="btn btn-primary mt-16">Clear Filters</a>
        </div>
        @endif
    </div>
</div>
@endsection
