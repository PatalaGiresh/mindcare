@extends('layouts.app')
@section('title', 'Booking Details')
@section('content')
<div style="max-width:640px;">
    <div class="mb-24"><a href="{{ route('patient.bookings.index') }}" style="font-size:0.875rem;color:var(--text-muted);">← Back to My Sessions</a></div>
    <h1 style="font-size:1.5rem;margin-bottom:24px;">Session Details</h1>

    <div class="card mb-24">
        <div class="card-header d-flex justify-between align-center">
            <h2 style="font-size:1rem;">Session Information</h2>
            <span class="badge {{ match($booking->session->status) {
                'pending'   => 'badge-warning',
                'confirmed' => 'badge-success',
                'completed' => 'badge-primary',
                'rejected'  => 'badge-danger',
                'cancelled' => 'badge-danger',
                default     => 'badge-muted'
            } }}">{{ ucfirst($booking->session->status) }}</span>
        </div>
        <div class="card-body">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div><div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:4px;">THERAPIST</div><div style="font-weight:600;">{{ $booking->session->therapist->name }}</div></div>
                <div><div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:4px;">SPECIALTY</div><div style="font-weight:600;">{{ $booking->session->therapist->therapistProfile->specialty ?? '—' }}</div></div>
                <div><div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:4px;">DATE & TIME</div><div style="font-weight:600;">{{ $booking->session->scheduled_at->format('D, M j, Y \a\t g:i A') }}</div></div>
                <div><div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:4px;">SESSION TYPE</div><div style="font-weight:600;">{{ ucfirst($booking->session->session_type) }}</div></div>
                <div><div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:4px;">BOOKED ON</div><div style="font-weight:600;">{{ $booking->created_at->format('M j, Y') }}</div></div>
            </div>

            {{-- PENDING --}}
            @if($booking->session->isPending())
            <div style="margin-top:20px;padding:14px;background:rgba(245,158,11,0.06);border-radius:var(--radius-sm);border:1px solid rgba(245,158,11,0.2);">
                <div style="font-weight:600;color:var(--warning);margin-bottom:4px;">Awaiting Therapist Confirmation</div>
                <div style="font-size:0.82rem;color:var(--text-muted);">Your booking request has been sent. The therapist will review and confirm or reject it shortly.</div>
            </div>
            @endif

            {{-- CONFIRMED + meeting link --}}
            @if($booking->session->isConfirmed())
            <div style="margin-top:20px;padding:14px;background:rgba(45,106,106,0.06);border-radius:var(--radius-sm);border:1px solid rgba(45,106,106,0.15);">
                <div style="font-weight:600;color:var(--primary);margin-bottom:8px;">Session Confirmed</div>
                @if($booking->session->meeting_link)
                <div style="margin-bottom:8px;font-size:0.82rem;color:var(--text-muted);">Your therapist has shared a meeting link:</div>
                <a href="{{ $booking->session->meeting_link }}" target="_blank" class="btn btn-primary">Join Session →</a>
                @else
                <div style="font-size:0.82rem;color:var(--text-muted);">Your session is confirmed. The therapist will share a meeting link before your session.</div>
                @endif
            </div>
            @endif

            {{-- COMPLETED --}}
            @if($booking->session->isCompleted())
            <div style="margin-top:20px;padding:14px;background:rgba(61,139,110,0.08);border-radius:var(--radius-sm);border:1px solid rgba(61,139,110,0.2);display:flex;align-items:center;gap:12px;">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;color:var(--success);"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <div style="font-weight:600;color:var(--success);">Session Completed</div>
                    <div style="font-size:0.82rem;color:var(--text-muted);margin-top:2px;">This session has been completed. Thank you for attending!</div>
                </div>
            </div>
            @endif

            {{-- REJECTED --}}
            @if($booking->session->isRejected())
            <div style="margin-top:20px;padding:14px;background:rgba(192,80,74,0.08);border-radius:var(--radius-sm);border:1px solid rgba(192,80,74,0.2);">
                <div style="font-weight:600;color:var(--danger);margin-bottom:4px;">Request Rejected</div>
                <div style="font-size:0.82rem;color:var(--text-muted);">The therapist was unable to take this session. Please book a different therapist or time slot.</div>
                <div style="margin-top:12px;"><a href="{{ route('therapists.index') }}" class="btn btn-primary btn-sm">Find Another Therapist</a></div>
            </div>
            @endif

            {{-- CANCELLED --}}
            @if($booking->session->isCancelled())
            <div style="margin-top:20px;padding:14px;background:rgba(192,80,74,0.08);border-radius:var(--radius-sm);border:1px solid rgba(192,80,74,0.2);">
                <div style="font-weight:600;color:var(--danger);margin-bottom:4px;">Session Cancelled</div>
                <div style="font-size:0.82rem;color:var(--text-muted);">This session has been cancelled.</div>
            </div>
            @endif
        </div>
    </div>

    <div class="d-flex gap-12">
        <a href="{{ route('messages.index', ['with' => $booking->session->therapist_id]) }}" class="btn btn-outline">Message Therapist</a>
        {{-- Cancel only within 1 hour of booking AND session still active --}}
        @if($booking->session->isActive() && $booking->created_at->diffInMinutes(now()) <= 60)
        <form method="POST" action="{{ route('patient.bookings.destroy', $booking) }}" onsubmit="return confirm('Cancel this booking?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger">Cancel Booking</button>
        </form>
        @endif
    </div>
</div>
@endsection
