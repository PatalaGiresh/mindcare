@extends('layouts.guest')
@section('title', $therapist->user->name)
@section('content')
<div class="section">
<div class="container">
    <div style="display:grid;grid-template-columns:1fr 360px;gap:32px;align-items:start;">
        {{-- Profile --}}
        <div>
            <div class="card mb-24">
                <div class="card-body">
                    <div class="d-flex align-center gap-24 mb-24">
                        <div class="therapist-avatar" style="width:90px;height:90px;font-size:2rem;">{{ strtoupper(substr($therapist->user->name,0,1)) }}</div>
                        <div>
                            <h1 style="font-size:1.6rem;margin-bottom:6px;">{{ $therapist->user->name }}</h1>
                            <div class="therapist-specialty mb-8">{{ $therapist->specialty }}</div>
                            <div class="d-flex gap-16">
                                <span class="rating-stars">★ {{ number_format($therapist->rating,1) }}</span>
                                <span style="font-size:0.85rem;color:var(--text-muted);">{{ $therapist->experience_years }} years experience</span>
                                <span style="font-size:0.85rem;color:var(--text-muted);">{{ $therapist->total_sessions }} sessions</span>
                            </div>
                        </div>
                    </div>
                    @if($therapist->is_available)<span class="badge badge-success mb-16">✓ Currently Available</span>@endif
                    <h2 style="font-size:1.1rem;margin-bottom:12px;">About</h2>
                    <p style="color:var(--text-secondary);line-height:1.75;">{{ $therapist->bio }}</p>
                </div>
            </div>
            <div class="card mb-24">
                <div class="card-body">
                    <h2 style="font-size:1.1rem;margin-bottom:16px;">Credentials & Details</h2>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        @if($therapist->qualification)<div><div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:4px;">QUALIFICATION</div><div style="font-weight:600;">{{ $therapist->qualification }}</div></div>@endif
                        <div><div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:4px;">EXPERIENCE</div><div style="font-weight:600;">{{ $therapist->experience_years }} Years</div></div>
                        @if($therapist->languages)<div><div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:4px;">LANGUAGES</div><div style="font-weight:600;">{{ $therapist->languages }}</div></div>@endif
                        <div><div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:4px;">SESSIONS</div><div style="font-weight:600;">{{ $therapist->total_sessions }} Completed</div></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Booking Widget --}}
        <div style="position:sticky;top:88px;">
            <div class="card">
                <div class="card-header"><h2 style="font-size:1.1rem;">Book a Session</h2></div>
                <div class="card-body">
                    <div style="font-size:2rem;font-weight:700;color:var(--primary);margin-bottom:4px;">₹{{ number_format($therapist->hourly_rate) }}<span style="font-size:1rem;font-weight:400;color:var(--text-muted);">/hour</span></div>
                    <p style="font-size:0.875rem;color:var(--text-muted);margin-bottom:24px;">60 minute therapy session</p>
                    @auth
                        @if(auth()->user()->isPatient())
                            <a href="{{ route('patient.bookings.create', ['therapist_id' => $therapist->id]) }}" class="btn btn-primary btn-block btn-lg">Book Now</a>
                        @elseif(auth()->user()->isTherapist())
                            <div class="alert alert-info" style="font-size:0.875rem;">Therapists cannot book sessions.</div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-block btn-lg">Login to Book</a>
                        <p style="text-align:center;font-size:0.8rem;color:var(--text-muted);margin-top:12px;">Don't have an account? <a href="{{ route('register') }}">Register free</a></p>
                    @endauth
                    <div style="margin-top:20px;padding-top:20px;border-top:1px solid var(--border-light);">
                        <div style="font-size:0.8rem;color:var(--text-muted);display:flex;flex-direction:column;gap:8px;">
                            <span>✓ Secure Razorpay payment</span>
                            <span>✓ Cancel 24+ hours before session</span>
                            <span>✓ Video, Audio, or Chat session</span>
                            <span>✓ Confidential & private</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
