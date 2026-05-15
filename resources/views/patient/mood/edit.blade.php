@extends('layouts.app')
@section('title', 'Edit Mood Log')
@section('content')
<div style="max-width:580px;">
    <div class="mb-24"><a href="{{ route('patient.mood.index') }}" style="font-size:0.875rem;color:var(--text-muted);">← Back to Mood Tracker</a></div>
    <h1 style="font-size:1.6rem;margin-bottom:28px;">Edit Mood Log</h1>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('patient.mood.update', $moodLog) }}">
                @csrf @method('PUT')
                <div class="form-group">
                    <label class="form-label">Mood Score</label>
                    <div class="mood-emoji-row"><span>😞</span><span>😟</span><span>😐</span><span>🙂</span><span>😄</span></div>
                    <input type="range" name="score" id="moodScore" class="mood-slider" min="1" max="10" value="{{ old('score', $moodLog->score) }}" oninput="updateScore(this.value)">
                    <div style="display:flex;justify-content:space-between;font-size:0.75rem;color:var(--text-muted);">
                        <span>1 — Very Low</span>
                        <span id="scoreDisplay" style="font-weight:700;color:var(--primary);font-size:1rem;">{{ old('score', $moodLog->score) }}/10</span>
                        <span>10 — Excellent</span>
                    </div>
                    @error('score')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Primary Emotion</label>
                    <select name="emotion" class="form-control form-select">
                        @foreach($emotions as $emotion)
                            <option value="{{ $emotion }}" {{ old('emotion', $moodLog->emotion)===$emotion?'selected':'' }}>{{ $emotion }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tags</label>
                    <div style="display:flex;flex-wrap:wrap;gap:8px;margin-top:6px;">
                        @foreach($tags as $tag)
                        <label style="cursor:pointer;">
                            <input type="checkbox" name="tags[]" value="{{ $tag }}" style="display:none;" {{ in_array($tag, old('tags', $moodLog->tags ?? [])) ? 'checked' : '' }} class="tag-toggle">
                            <span class="tag-chip {{ in_array($tag, old('tags', $moodLog->tags ?? [])) ? 'selected' : '' }}">{{ $tag }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Journal Note</label>
                    <textarea name="note" class="form-control" rows="4">{{ old('note', $moodLog->note) }}</textarea>
                </div>
                <div class="d-flex gap-12">
                    <button type="submit" class="btn btn-primary">Update Log</button>
                    <a href="{{ route('patient.mood.index') }}" class="btn btn-ghost">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
function updateScore(val) { document.getElementById('scoreDisplay').textContent = val + '/10'; }
document.querySelectorAll('.tag-toggle').forEach(cb => {
    cb.addEventListener('change', function() { this.nextElementSibling.classList.toggle('selected', this.checked); });
});
</script>
@endpush
