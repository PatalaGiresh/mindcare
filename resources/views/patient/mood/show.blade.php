@extends('layouts.app')
@section('title', 'Mood Log Detail')
@section('content')
<div style="max-width:580px;">
    <div class="mb-24"><a href="{{ route('patient.mood.index') }}" style="font-size:0.875rem;color:var(--text-muted);">← Back to Mood Tracker</a></div>
    <div class="card">
        <div class="card-body">
            <div style="text-align:center;padding:24px 0;">
                <div style="font-size:4rem;margin-bottom:12px;">{{ $moodLog->score >= 8 ? '😄' : ($moodLog->score >= 6 ? '🙂' : ($moodLog->score >= 4 ? '😐' : '😞')) }}</div>
                <div style="font-size:3rem;font-weight:700;color:{{ $moodLog->mood_color }};">{{ $moodLog->score }}/10</div>
                <div class="badge mt-8" style="background:{{ $moodLog->mood_color }}22;color:{{ $moodLog->mood_color }};font-size:0.9rem;padding:6px 16px;">{{ $moodLog->mood_label }}</div>
                @if($moodLog->emotion)<div style="margin-top:10px;color:var(--text-muted);">Feeling: <strong>{{ $moodLog->emotion }}</strong></div>@endif
                <div style="margin-top:6px;font-size:0.875rem;color:var(--text-muted);">{{ $moodLog->logged_at->format('l, M j, Y \a\t g:i A') }}</div>
            </div>
            @if($moodLog->tags && count($moodLog->tags) > 0)
            <div style="border-top:1px solid var(--border-light);padding-top:20px;margin-top:8px;">
                <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:8px;">TAGS</div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    @foreach($moodLog->tags as $tag)<span class="badge badge-muted">{{ $tag }}</span>@endforeach
                </div>
            </div>
            @endif
            @if($moodLog->note)
            <div style="border-top:1px solid var(--border-light);padding-top:20px;margin-top:16px;">
                <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:8px;">JOURNAL NOTE</div>
                <p style="color:var(--text-secondary);line-height:1.75;">{{ $moodLog->note }}</p>
            </div>
            @endif
            <div class="d-flex gap-12 mt-24">
                <a href="{{ route('patient.mood.edit', $moodLog) }}" class="btn btn-outline">Edit</a>
                <form method="POST" action="{{ route('patient.mood.destroy', $moodLog) }}" onsubmit="return confirm('Delete this mood log?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
