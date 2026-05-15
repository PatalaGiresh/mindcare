@extends('layouts.app')
@section('title', 'My Bookings')
@section('content')
<div class="d-flex justify-between align-center mb-32">
    <div>
        <h1 style="font-size:1.6rem;margin-bottom:4px;">My Sessions</h1>
        <p style="color:var(--text-muted);">Your therapy session requests and bookings</p>
    </div>
    <a href="{{ route('therapists.index') }}" class="btn btn-primary">+ Book New Session</a>
</div>

@if(session('success'))
<div class="alert alert-success mb-24">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-error mb-24">{{ session('error') }}</div>
@endif

<div class="card">
    @forelse($bookings as $booking)
    @php $session = $booking->session; @endphp
    <div style="padding:20px 24px;border-bottom:1px solid var(--border-light);">
        <div class="d-flex align-center gap-16">
            <div class="therapist-avatar" style="width:50px;height:50px;font-size:1.1rem;flex-shrink:0;">{{ strtoupper(substr($session->therapist->name,0,1)) }}</div>
            <div style="flex:1;">
                <div style="font-weight:700;">{{ $session->therapist->name }}</div>
                <div style="font-size:0.82rem;color:var(--text-muted);">{{ $session->therapist->therapistProfile->specialty ?? '' }}</div>
                <div style="font-size:0.82rem;color:var(--text-muted);margin-top:4px;">{{ $session->scheduled_at->format('D, M j, Y \a\t g:i A') }} &bull; {{ ucfirst($session->session_type) }}</div>
            </div>
            <div style="text-align:right;flex-shrink:0;">
                {{-- Status badge --}}
                <span class="badge {{ match($session->status) {
                    'pending'   => 'badge-warning',
                    'confirmed' => 'badge-success',
                    'completed' => 'badge-primary',
                    'rejected'  => 'badge-danger',
                    'cancelled' => 'badge-danger',
                    default     => 'badge-muted'
                } }}">{{ ucfirst($session->status) }}</span>

                {{-- Status sub-message --}}
                <div style="font-size:0.72rem;color:var(--text-muted);margin-top:4px;">
                    @if($session->isPending()) Awaiting therapist confirmation
                    @elseif($session->isConfirmed()) Session confirmed
                    @elseif($session->isCompleted()) Session completed
                    @elseif($session->isRejected()) Request rejected by therapist
                    @elseif($session->isCancelled()) Cancelled
                    @endif
                </div>

                {{-- Cancel within 1 hour of booking --}}
                @if($session->isActive() && $booking->created_at->diffInMinutes(now()) <= 60)
                <form method="POST" action="{{ route('patient.bookings.destroy', $booking) }}" onsubmit="return confirm('Cancel this booking?')" class="mt-8">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                </form>
                @elseif($session->isActive())
                <div style="font-size:0.72rem;color:var(--text-muted);margin-top:6px;">Cancel window passed</div>
                @endif
            </div>
        </div>

        {{-- Meeting link — only while confirmed (active session) --}}
        @if($session->meeting_link && $session->isConfirmed())
        <div style="margin-top:12px;padding:12px 16px;background:rgba(45,106,106,0.06);border-radius:var(--radius-sm);border:1px solid rgba(45,106,106,0.15);display:flex;align-items:center;gap:12px;">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;color:var(--primary);"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            <span style="font-size:0.82rem;color:var(--text-muted);flex:1;">Your therapist shared a meeting link</span>
            <a href="{{ $session->meeting_link }}" target="_blank" class="btn btn-primary btn-sm">Join Session →</a>
        </div>
        @endif

        {{-- Completed banner --}}
        @if($session->isCompleted())
        <div style="margin-top:10px;padding:10px 14px;background:rgba(61,139,110,0.06);border-radius:var(--radius-sm);font-size:0.82rem;color:var(--success);">
            Session completed. Thank you for attending!
        </div>
        @endif

        {{-- Rejected banner --}}
        @if($session->isRejected())
        <div style="margin-top:10px;padding:10px 14px;background:rgba(192,80,74,0.06);border-radius:var(--radius-sm);font-size:0.82rem;color:var(--danger);">
            Your request was rejected. <a href="{{ route('therapists.index') }}" style="color:var(--primary);font-weight:600;">Find another therapist →</a>
        </div>
        @endif
    </div>
    @empty
    <div style="text-align:center;padding:60px;">
        <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 16px;display:block;color:var(--border);"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        <h3>No sessions yet</h3>
        <p style="color:var(--text-muted);margin-top:8px;">Book your first therapy session to get started.</p>
        <a href="{{ route('therapists.index') }}" class="btn btn-primary mt-16">Find a Therapist</a>
    </div>
    @endforelse
    @if($bookings->hasPages())<div style="padding:16px 24px;">{{ $bookings->links() }}</div>@endif
</div>
@endsection
