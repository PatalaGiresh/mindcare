@extends('layouts.app')
@section('title', 'Mood Tracker')
@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endpush
@section('content')
<div class="d-flex justify-between align-center mb-32">
    <div>
        <h1 style="font-size:1.6rem;margin-bottom:4px;">Mood Tracker</h1>
        <p style="color:var(--text-muted);">Track your emotional wellbeing over time</p>
    </div>
    <a href="{{ route('patient.mood.create') }}" class="btn btn-primary">+ Log Today's Mood</a>
</div>

@if($chartData->count() > 0)
<div class="mood-chart-container mb-32">
    <h2 style="font-size:1.05rem;margin-bottom:20px;">Your Mood Journey (Last 30 Days)</h2>
    <canvas id="moodChart" height="70"></canvas>
</div>
@endif

<div class="card">
    <div class="card-header"><h2 style="font-size:1.05rem;">All Mood Logs</h2></div>
    @forelse($logs as $log)
    <div style="padding:18px 24px;border-bottom:1px solid var(--border-light);display:flex;align-items:center;gap:16px;">
        <div style="width:48px;height:48px;border-radius:50%;background:{{ $log->mood_color }}22;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0;">
            {{ $log->score >= 8 ? '😄' : ($log->score >= 6 ? '🙂' : ($log->score >= 4 ? '😐' : '😞')) }}
        </div>
        <div style="flex:1;">
            <div class="d-flex align-center gap-12 mb-4">
                <span style="font-weight:700;color:{{ $log->mood_color }};">{{ $log->score }}/10</span>
                <span class="badge" style="background:{{ $log->mood_color }}22;color:{{ $log->mood_color }};">{{ $log->mood_label }}</span>
                @if($log->emotion)<span class="badge badge-muted">{{ $log->emotion }}</span>@endif
            </div>
            @if($log->note)<p style="font-size:0.875rem;color:var(--text-muted);margin-bottom:4px;">{{ Str::limit($log->note, 100) }}</p>@endif
            @if($log->tags && count($log->tags) > 0)
                <div style="display:flex;gap:6px;flex-wrap:wrap;">
                    @foreach($log->tags as $tag)<span class="badge badge-muted" style="font-size:0.72rem;">{{ $tag }}</span>@endforeach
                </div>
            @endif
        </div>
        <div style="text-align:right;flex-shrink:0;">
            <div style="font-size:0.82rem;color:var(--text-muted);">{{ $log->logged_at->format('M j, Y') }}</div>
            <div style="font-size:0.75rem;color:var(--text-muted);">{{ $log->logged_at->format('g:i A') }}</div>
            <div class="d-flex gap-8 mt-8" style="justify-content:flex-end;">
                <a href="{{ route('patient.mood.edit',$log) }}" class="btn btn-ghost btn-sm">Edit</a>
                <form method="POST" action="{{ route('patient.mood.destroy',$log) }}" onsubmit="return confirm('Delete this log?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div style="text-align:center;padding:60px;">
        <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 16px;display:block;color:var(--border);"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
        <h3>No mood logs yet</h3>
        <p style="color:var(--text-muted);margin-top:8px;">Start tracking your mood to see patterns emerge.</p>
        <a href="{{ route('patient.mood.create') }}" class="btn btn-primary mt-16">Log Your First Mood</a>
    </div>
    @endforelse
    @if($logs->hasPages())<div style="padding:16px 24px;">{{ $logs->links() }}</div>@endif
</div>
@endsection
@push('scripts')
@if($chartData->count() > 0)
<script>
new Chart(document.getElementById('moodChart').getContext('2d'), {
    type: 'line',
    data: {
        labels: {!! json_encode($chartData->pluck('logged_at')->map(fn($d) => \Carbon\Carbon::parse($d)->format('M j'))) !!},
        datasets: [{
            label: 'Mood',
            data: {!! json_encode($chartData->pluck('score')) !!},
            borderColor: '#2D6A6A', backgroundColor: 'rgba(45,106,106,0.08)',
            borderWidth: 2.5, tension: 0.4, fill: true, pointBackgroundColor: '#2D6A6A', pointRadius: 4,
        }]
    },
    options: { responsive: true, scales: { y: { min:1, max:10, ticks:{stepSize:1} }, x: { grid:{display:false} } }, plugins:{legend:{display:false}} }
});
</script>
@endif
@endpush
