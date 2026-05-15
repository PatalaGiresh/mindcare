@extends('layouts.app')
@section('title', 'Therapist Dashboard')
@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endpush
@section('content')
<h1 style="font-size:1.6rem;margin-bottom:4px;">Welcome, {{ auth()->user()->name }}</h1>
<p style="color:var(--text-muted);margin-bottom:32px;">Here's your practice overview.</p>

{{-- Stats (no money) --}}
<div class="grid-3 mb-32">
    <div class="stat-card">
        <div class="stat-icon stat-icon-warm">
            <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="stat-number">{{ $pendingCount }}</div>
        <div class="stat-label">Pending Requests</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-icon-green">
            <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <div class="stat-number">{{ $totalPatients }}</div>
        <div class="stat-label">Total Patients</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-icon-accent">
            <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="stat-number">{{ $totalCompleted }}</div>
        <div class="stat-label">Sessions Completed</div>
    </div>
</div>

{{-- Pending Requests -- needs action --}}
@if($pendingRequests->count() > 0)
<div class="card mb-24">
    <div class="card-header d-flex justify-between align-center">
        <div>
            <h2 style="font-size:1.05rem;">Pending Requests</h2>
            <p style="font-size:0.8rem;color:var(--text-muted);margin-top:2px;">Review and confirm or reject these booking requests</p>
        </div>
        <a href="{{ route('therapist.sessions.index', ['status'=>'pending']) }}" style="font-size:0.85rem;color:var(--primary);">View all →</a>
    </div>
    <div class="card-body p-0">
        @foreach($pendingRequests as $session)
        <div style="padding:16px 24px;border-bottom:1px solid var(--border-light);display:flex;align-items:center;gap:14px;">
            <div class="therapist-avatar" style="width:42px;height:42px;font-size:0.95rem;flex-shrink:0;">{{ strtoupper(substr($session->patient->name,0,1)) }}</div>
            <div style="flex:1;">
                <div style="font-weight:600;font-size:0.9rem;">{{ $session->patient->name }}</div>
                <div style="font-size:0.78rem;color:var(--text-muted);">{{ $session->scheduled_at->format('D, M j, Y \a\t g:i A') }} &bull; {{ ucfirst($session->session_type) }}</div>
                @if($session->patient_notes)
                <div style="font-size:0.75rem;color:var(--text-muted);margin-top:3px;font-style:italic;">"{{ Str::limit($session->patient_notes, 60) }}"</div>
                @endif
            </div>
            <div style="display:flex;gap:8px;flex-shrink:0;">
                <form method="POST" action="{{ route('therapist.sessions.status', $session) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="confirmed">
                    <button type="submit" class="btn btn-primary btn-sm">Confirm</button>
                </form>
                <form method="POST" action="{{ route('therapist.sessions.status', $session) }}" onsubmit="return confirm('Reject this session request?')">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="rejected">
                    <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
    {{-- Upcoming Confirmed Sessions --}}
    <div class="card">
        <div class="card-header d-flex justify-between align-center">
            <h2 style="font-size:1.05rem;">Upcoming Sessions</h2>
            <a href="{{ route('therapist.sessions.index', ['status'=>'confirmed']) }}" style="font-size:0.85rem;color:var(--primary);">View all →</a>
        </div>
        <div class="card-body p-0">
            @forelse($upcomingSessions as $session)
            <div style="padding:16px 24px;border-bottom:1px solid var(--border-light);display:flex;align-items:center;gap:14px;">
                <div class="therapist-avatar" style="width:40px;height:40px;font-size:0.9rem;flex-shrink:0;">{{ strtoupper(substr($session->patient->name,0,1)) }}</div>
                <div style="flex:1;">
                    <div style="font-weight:600;font-size:0.9rem;">{{ $session->patient->name }}</div>
                    <div style="font-size:0.78rem;color:var(--text-muted);">{{ $session->scheduled_at->format('M j, Y g:i A') }} &bull; {{ ucfirst($session->session_type) }}</div>
                    @if(!$session->meeting_link)
                    <div style="font-size:0.72rem;color:var(--warning);margin-top:2px;">⚠ Meeting link not set</div>
                    @endif
                </div>
                <div style="text-align:right;">
                    <span class="badge badge-success">Confirmed</span>
                    <div class="mt-8"><a href="{{ route('therapist.sessions.show', $session) }}" class="btn btn-primary btn-sm">Manage</a></div>
                </div>
            </div>
            @empty
            <div style="padding:32px;text-align:center;color:var(--text-muted);">No upcoming confirmed sessions</div>
            @endforelse
        </div>
    </div>

    {{-- Recently Completed --}}
    <div class="card">
        <div class="card-header d-flex justify-between align-center">
            <h2 style="font-size:1.05rem;">Recently Completed</h2>
            <a href="{{ route('therapist.sessions.index', ['status'=>'completed']) }}" style="font-size:0.85rem;color:var(--primary);">View all →</a>
        </div>
        <div class="card-body p-0">
            @forelse($recentSessions as $session)
            <div style="padding:14px 24px;border-bottom:1px solid var(--border-light);display:flex;align-items:center;gap:14px;">
                <div class="therapist-avatar" style="width:36px;height:36px;font-size:0.85rem;flex-shrink:0;">{{ strtoupper(substr($session->patient->name,0,1)) }}</div>
                <div style="flex:1;">
                    <div style="font-weight:600;font-size:0.875rem;">{{ $session->patient->name }}</div>
                    <div style="font-size:0.78rem;color:var(--text-muted);">{{ $session->scheduled_at->format('M j, Y') }}</div>
                </div>
                <span class="badge badge-primary">Completed</span>
            </div>
            @empty
            <div style="padding:32px;text-align:center;color:var(--text-muted);">No completed sessions yet</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
