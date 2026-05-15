@extends('layouts.app')
@section('title', 'My Dashboard')
@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endpush
@section('content')
<h1 style="font-size:1.6rem;margin-bottom:4px;">Welcome back, {{ auth()->user()->name }}</h1>
<p style="color:var(--text-muted);margin-bottom:32px;">Here's how you're doing today.</p>

<div class="grid-4 mb-32">
    <div class="stat-card">
        <div class="stat-icon stat-icon-teal">
            <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <div class="stat-number">{{ $totalSessions }}</div>
        <div class="stat-label">Total Sessions</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-icon-green">
            <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="stat-number">{{ $completedCount }}</div>
        <div class="stat-label">Completed</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-icon-accent">
            <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
        </div>
        <div class="stat-number">{{ number_format($avgMood, 1) }}/10</div>
        <div class="stat-label">Avg Mood Score</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-icon-warm">
            <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
        </div>
        <div class="stat-number">{{ $unreadMessages }}</div>
        <div class="stat-label">Unread Messages</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:24px;">
    <div>
        <div class="mood-chart-container mb-24">
            <div class="d-flex justify-between align-center mb-16">
                <h2 style="font-size:1.1rem;">Mood Trend — Last 7 Days</h2>
                <a href="{{ route('patient.mood.create') }}" class="btn btn-primary btn-sm">Log Today's Mood</a>
            </div>
            @if($moodLogs->count() > 0)
                <canvas id="moodChart" height="80"></canvas>
            @else
                <div style="text-align:center;padding:40px;color:var(--text-muted);">
                    <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 12px;display:block;color:var(--border);"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <p>No mood logs yet. Start tracking your mood!</p>
                    <a href="{{ route('patient.mood.create') }}" class="btn btn-primary mt-12">Log First Mood</a>
                </div>
            @endif
        </div>

        <div class="card">
            <div class="card-header d-flex justify-between align-center">
                <h2 style="font-size:1.1rem;">Upcoming Sessions</h2>
                <a href="{{ route('patient.bookings.index') }}" style="font-size:0.85rem;color:var(--primary);">View all</a>
            </div>
            <div class="card-body p-0">
                @forelse($upcomingSessions as $session)
                <div style="padding:16px 24px;border-bottom:1px solid var(--border-light);">
                    <div style="display:flex;align-items:center;gap:16px;">
                        <div class="therapist-avatar" style="width:40px;height:40px;font-size:0.9rem;flex-shrink:0;">{{ strtoupper(substr($session->therapist->name,0,1)) }}</div>
                        <div style="flex:1;">
                            <div style="font-weight:600;font-size:0.9rem;">{{ $session->therapist->name }}</div>
                            <div style="font-size:0.8rem;color:var(--text-muted);">{{ $session->scheduled_at->format('D, M j \a\t g:i A') }}</div>
                        </div>
                        <span class="badge {{ match($session->status) {
                            'pending'   => 'badge-warning',
                            'confirmed' => 'badge-success',
                            'completed' => 'badge-primary',
                            'rejected'  => 'badge-danger',
                            'cancelled' => 'badge-danger',
                            default     => 'badge-muted'
                        } }}">{{ ucfirst($session->status) }}</span>
                    </div>
                    {{-- Status messages --}}
                    @if($session->isPending())
                    <div style="margin-top:8px;font-size:0.78rem;color:var(--warning);padding-left:56px;">Awaiting therapist confirmation…</div>
                    @elseif($session->isConfirmed() && $session->meeting_link)
                    <div style="margin-top:8px;padding-left:56px;">
                        <a href="{{ $session->meeting_link }}" target="_blank" class="btn btn-primary btn-sm">Join Session →</a>
                    </div>
                    @elseif($session->isConfirmed())
                    <div style="margin-top:8px;font-size:0.78rem;color:var(--text-muted);padding-left:56px;">Confirmed — meeting link will appear here once set by therapist</div>
                    @elseif($session->isCompleted())
                    <div style="margin-top:8px;font-size:0.78rem;color:var(--success);padding-left:56px;">Session completed</div>
                    @endif
                </div>
                @empty
                <div style="padding:32px;text-align:center;color:var(--text-muted);">
                    <p style="margin-bottom:12px;">No upcoming sessions</p>
                    <a href="{{ route('therapists.index') }}" class="btn btn-primary btn-sm">Book a Session</a>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div>
        <div class="card mb-24">
            <div class="card-body">
                <h2 style="font-size:1rem;margin-bottom:16px;">Quick Actions</h2>
                <div style="display:flex;flex-direction:column;gap:10px;">
                    <a href="{{ route('patient.mood.create') }}" class="btn btn-primary btn-block">Log Today's Mood</a>
                    <a href="{{ route('therapists.index') }}" class="btn btn-outline btn-block">Find a Therapist</a>
                    <a href="{{ route('patient.bookings.index') }}" class="btn btn-ghost btn-block">My Bookings</a>
                    <a href="{{ route('messages.index') }}" class="btn btn-ghost btn-block">
                        Messages
                        @if($unreadMessages>0)<span class="badge badge-danger" style="margin-left:8px;">{{ $unreadMessages }}</span>@endif
                    </a>
                    <a href="{{ route('resources.index') }}" class="btn btn-ghost btn-block">Browse Resources</a>
                </div>
            </div>
        </div>

        @if($moodLogs->count() === 0 || optional($moodLogs->last())->logged_at?->isToday() === false)
        <div style="background:linear-gradient(135deg,var(--accent),var(--primary));border-radius:var(--radius-md);padding:24px;color:#fff;text-align:center;">
            <svg width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 10px;display:block;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            <div style="font-weight:600;margin-bottom:6px;">How are you feeling today?</div>
            <div style="font-size:0.82rem;opacity:0.85;margin-bottom:16px;">Track your mood to understand your patterns</div>
            <a href="{{ route('patient.mood.create') }}" class="btn" style="background:#fff;color:var(--primary);font-weight:700;">Log Now</a>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
@if($moodLogs->count() > 0)
<script>
new Chart(document.getElementById('moodChart').getContext('2d'), {
    type: 'line',
    data: {
        labels: {!! json_encode($moodLogs->pluck('logged_at')->map(fn($d) => \Carbon\Carbon::parse($d)->format('M j'))) !!},
        datasets: [{
            label: 'Mood Score',
            data: {!! json_encode($moodLogs->pluck('score')) !!},
            borderColor: '#2D6A6A', backgroundColor: 'rgba(45,106,106,0.08)',
            borderWidth: 2.5, tension: 0.4, fill: true,
            pointBackgroundColor: '#2D6A6A', pointRadius: 5,
        }]
    },
    options: {
        responsive: true,
        scales: { y: { min:1, max:10, ticks:{stepSize:1}, grid:{color:'rgba(0,0,0,0.04)'} }, x: { grid:{display:false} } },
        plugins: { legend:{display:false} }
    }
});
</script>
@endif
@endpush
