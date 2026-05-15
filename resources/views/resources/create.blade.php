@extends('layouts.app')
@section('title', 'Resources')
@section('content')
<div class="d-flex justify-between align-center mb-32">
    <div><h1 style="font-size:1.6rem;margin-bottom:4px;">Publish a Resource</h1><p style="color:var(--text-muted);">Share evidence-based mental health content</p></div>
    <a href="{{ route('resources.index') }}" class="btn btn-ghost">← Back to Resources</a>
</div>
<div style="max-width:700px;">
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('resources.store') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control {{ $errors->has('title')?'is-invalid':'' }}" value="{{ old('title') }}" placeholder="e.g. How to Manage Anxiety at Work" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-control form-select {{ $errors->has('category')?'is-invalid':'' }}">
                            <option value="">Select category...</option>
                            @foreach($categories as $cat)<option value="{{ $cat }}" {{ old('category')===$cat?'selected':'' }}>{{ $cat }}</option>@endforeach
                        </select>
                        @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Read Time</label>
                        <input type="text" name="read_time" class="form-control" value="{{ old('read_time') }}" placeholder="e.g. 5 min read">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Excerpt <span style="color:var(--text-muted);font-weight:400;">(short summary)</span></label>
                    <textarea name="excerpt" class="form-control" rows="2" placeholder="Brief description shown in article listings...">{{ old('excerpt') }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Article Body</label>
                    <textarea name="body" class="form-control {{ $errors->has('body')?'is-invalid':'' }}" rows="12" placeholder="Write your article content here... HTML is supported.">{{ old('body') }}</textarea>
                    @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-primary btn-lg">Publish Article</button>
            </form>
        </div>
    </div>
</div>
@endsection
