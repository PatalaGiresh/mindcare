@extends('layouts.guest')
@section('title', $resource->title)
@section('content')
<div class="section-sm">
    <div class="container-sm">
        <a href="{{ route('resources.index') }}" style="font-size:0.875rem;color:var(--text-muted);display:inline-block;margin-bottom:24px;">← Back to Resources</a>
        <span class="badge badge-info mb-16">{{ $resource->category }}</span>
        <h1 style="font-size:2rem;margin-bottom:16px;line-height:1.25;">{{ $resource->title }}</h1>
        <div class="d-flex align-center gap-16 mb-32" style="color:var(--text-muted);font-size:0.875rem;">
            <span>By {{ $resource->author->name }}</span>
            <span>•</span>
            <span>{{ $resource->read_time ?? '5 min read' }}</span>
            <span>•</span>
            <span>{{ $resource->published_at->format('M j, Y') }}</span>
        </div>
        <div style="font-size:1.05rem;line-height:1.85;color:var(--text-secondary);">
            {!! $resource->body !!}
        </div>
        <div style="margin-top:48px;padding-top:32px;border-top:1px solid var(--border-light);background:rgba(45,106,106,0.04);border-radius:var(--radius-md);padding:24px;text-align:center;">
            <h3 style="font-size:1.2rem;margin-bottom:8px;">Ready to talk to a professional?</h3>
            <p style="color:var(--text-muted);margin-bottom:20px;">Our verified therapists are here to support you.</p>
            <a href="{{ route('therapists.index') }}" class="btn btn-primary btn-lg">Find a Therapist →</a>
        </div>
        @if($related->count() > 0)
        <div style="margin-top:48px;">
            <h2 style="font-size:1.2rem;margin-bottom:24px;">Related Articles</h2>
            <div class="grid-3">
                @foreach($related as $rel)
                <a href="{{ route('resources.show',$rel) }}" class="card" style="text-decoration:none;">
                    <div class="card-body">
                        <span class="badge badge-info mb-8" style="font-size:0.72rem;">{{ $rel->category }}</span>
                        <div style="font-weight:600;font-size:0.9rem;color:var(--text-primary);">{{ Str::limit($rel->title,60) }}</div>
                        <div style="font-size:0.78rem;color:var(--text-muted);margin-top:6px;">{{ $rel->read_time ?? '5 min' }}</div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
