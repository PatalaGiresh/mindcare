@extends('layouts.app')
@section('title', 'Book a Session')
@section('content')
<div style="max-width:640px;">
    <div class="mb-24"><a href="{{ route('therapists.index') }}" style="font-size:0.875rem;color:var(--text-muted);">← Back to Therapists</a></div>
    <h1 style="font-size:1.6rem;margin-bottom:4px;">Book a Session</h1>
    <p style="color:var(--text-muted);margin-bottom:32px;">with {{ $therapist->user->name }}</p>

    <div class="card mb-24" style="background:rgba(45,106,106,0.05);border-color:rgba(45,106,106,0.2);">
        <div class="card-body d-flex align-center gap-16">
            <div class="therapist-avatar">{{ strtoupper(substr($therapist->user->name,0,1)) }}</div>
            <div>
                <div style="font-weight:700;">{{ $therapist->user->name }}</div>
                <div class="therapist-specialty">{{ $therapist->specialty }}</div>
            </div>
            <div style="margin-left:auto;text-align:right;">
                <div style="font-weight:700;font-size:1.2rem;color:var(--primary);">₹{{ number_format($therapist->hourly_rate) }}</div>
                <div style="font-size:0.8rem;color:var(--text-muted);">per session (60 min)</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('patient.bookings.store') }}">
                @csrf
                <input type="hidden" name="therapist_id" value="{{ $therapist->id }}">

                <div class="form-group">
                    <label class="form-label">Preferred Date & Time</label>
                    <input type="datetime-local" name="scheduled_at" class="form-control {{ $errors->has('scheduled_at')?'is-invalid':'' }}"
                           value="{{ old('scheduled_at') }}" min="{{ now()->addHours(2)->format('Y-m-d\TH:i') }}">
                    @error('scheduled_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Session Type</label>
                    <select name="session_type" class="form-control form-select {{ $errors->has('session_type')?'is-invalid':'' }}">
                        <option value="video" {{ old('session_type')==='video'?'selected':'' }}>Video Call</option>
                        <option value="audio" {{ old('session_type')==='audio'?'selected':'' }}>Audio Call</option>
                        <option value="chat" {{ old('session_type')==='chat'?'selected':'' }}>Text Chat</option>
                    </select>
                    @error('session_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Notes for Therapist <span style="color:var(--text-muted);font-weight:400;">(optional)</span></label>
                    <textarea name="patient_notes" class="form-control" rows="3" placeholder="Share what you'd like to work on in this session...">{{ old('patient_notes') }}</textarea>
                </div>

                <div style="background:var(--surface);border-radius:var(--radius-sm);padding:16px;margin-bottom:20px;">
                    <div style="font-weight:600;margin-bottom:8px;">Payment Summary</div>
                    <div class="d-flex justify-between" style="font-size:0.9rem;color:var(--text-muted);margin-bottom:6px;"><span>Session fee (60 min)</span><span>₹{{ number_format($therapist->hourly_rate) }}</span></div>
                    <div class="d-flex justify-between" style="font-weight:700;border-top:1px solid var(--border);padding-top:8px;margin-top:8px;"><span>Total</span><span style="color:var(--primary);">₹{{ number_format($therapist->hourly_rate) }}</span></div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg btn-block">Proceed to Payment →</button>
                <p style="text-align:center;font-size:0.78rem;color:var(--text-muted);margin-top:10px;">Secured by Razorpay • Cancel 24hrs before session</p>
            </form>
        </div>
    </div>
</div>
@endsection
