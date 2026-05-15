@extends('layouts.app')
@section('title', 'Log Your Mood')

@section('content')
<div style="max-width:580px;">
    <div class="mb-24">
        <a href="{{ route('patient.mood.index') }}" style="font-size:0.875rem;color:var(--text-muted);">← Back to Mood Tracker</a>
    </div>
    <h1 style="font-size:1.6rem;margin-bottom:4px;">How are you feeling?</h1>
    <p style="color:var(--text-muted);margin-bottom:32px;">Take a moment to check in with yourself</p>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('patient.mood.store') }}">
                @csrf

                {{-- Mood Score --}}
                <div class="form-group">
                    <label class="form-label">Mood Score</label>
                    <div class="mood-emoji-row">
                        <span title="Very Low">😞</span><span title="Low">😟</span><span title="Neutral">😐</span><span title="Good">🙂</span><span title="Excellent">😄</span>
                    </div>
                    <input type="range" name="score" id="moodScore" class="mood-slider" min="1" max="10" value="{{ old('score', 5) }}" oninput="updateScore(this.value)">
                    <div style="display:flex;justify-content:space-between;font-size:0.75rem;color:var(--text-muted);">
                        <span>1 — Very Low</span>
                        <span id="scoreDisplay" style="font-weight:700;color:var(--primary);font-size:1rem;">{{ old('score', 5) }}/10</span>
                        <span>10 — Excellent</span>
                    </div>
                    @error('score')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Emotion --}}
                <div class="form-group">
                    <label class="form-label">Primary Emotion</label>
                    <select name="emotion" class="form-control form-select {{ $errors->has('emotion')?'is-invalid':'' }}">
                        <option value="">Select your emotion...</option>
                        @foreach($emotions as $emotion)
                            <option value="{{ $emotion }}" {{ old('emotion')===$emotion?'selected':'' }}>{{ $emotion }}</option>
                        @endforeach
                    </select>
                    @error('emotion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Tags --}}
                <div class="form-group">
                    <label class="form-label">What's affecting your mood? <span style="color:var(--text-muted);font-weight:400;">(optional)</span></label>
                    <div style="display:flex;flex-wrap:wrap;gap:8px;margin-top:6px;">
                        @foreach($tags as $tag)
                        <label style="cursor:pointer;">
                            <input type="checkbox" name="tags[]" value="{{ $tag }}" style="display:none;" {{ in_array($tag, old('tags',[])) ? 'checked' : '' }} class="tag-toggle">
                            <span class="tag-chip {{ in_array($tag, old('tags',[])) ? 'selected' : '' }}">{{ $tag }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Note --}}
                <div class="form-group">
                    <label class="form-label">Journal Note <span style="color:var(--text-muted);font-weight:400;">(optional)</span></label>
                    <textarea name="note" class="form-control" rows="4" placeholder="Write anything on your mind... this is your private space.">{{ old('note') }}</textarea>
                    @error('note')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn btn-primary btn-lg btn-block">Save Mood Log</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateScore(val) {
    document.getElementById('scoreDisplay').textContent = val + '/10';
}
document.querySelectorAll('.tag-toggle').forEach(cb => {
    cb.addEventListener('change', function() {
        this.nextElementSibling.classList.toggle('selected', this.checked);
    });
});
</script>
@endpush
