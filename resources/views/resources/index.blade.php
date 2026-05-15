@extends('layouts.guest')
@section('title', 'Mental Health Resources')
@section('content')
<div style="background:var(--card);border-bottom:1px solid var(--border-light);padding:40px 0;">
    <div class="container">
        <h1 style="font-size:2rem;margin-bottom:8px;">Mental Health Resources</h1>
        <p style="color:var(--text-muted);">Evidence-based articles and guides to support your wellbeing</p>
        <form method="GET" action="{{ route('resources.index') }}" style="margin-top:24px;display:flex;gap:12px;flex-wrap:wrap;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search articles..." class="form-control" style="max-width:280px;">
            <select name="category" class="form-control form-select" style="max-width:200px;">
                <option value="">All Categories</option>
                @foreach($categories as $cat)<option value="{{ $cat }}" {{ request('category')===$cat?'selected':'' }}>{{ $cat }}</option>@endforeach
            </select>
            <button type="submit" class="btn btn-primary">Search</button>
            @if(request()->hasAny(['search','category']))<a href="{{ route('resources.index') }}" class="btn btn-ghost">Clear</a>@endif
        </form>
    </div>
</div>
<div class="section">
    <div class="container">
        @if($resources->count() > 0)
        <div class="grid-3">
            @foreach($resources as $resource)
            <div class="card">
                <div style="height:5px;background:linear-gradient(90deg,var(--primary),var(--accent));"></div>
                <div class="card-body">
                    <span class="badge badge-info mb-12">{{ $resource->category }}</span>
                    <h2 style="font-size:1.05rem;margin-bottom:10px;line-height:1.35;">{{ $resource->title }}</h2>
                    <p style="color:var(--text-muted);font-size:0.875rem;line-height:1.65;margin-bottom:16px;">{{ Str::limit($resource->excerpt, 120) }}</p>
                    <div class="d-flex justify-between align-center">
                        <div style="font-size:0.78rem;color:var(--text-muted);">
                            <span>{{ $resource->read_time ?? '5 min read' }}</span>
                            <span style="margin:0 8px;">•</span>
                            <span>{{ $resource->published_at->diffForHumans() }}</span>
                        </div>
                        <a href="{{ route('resources.show',$resource) }}" class="btn btn-ghost btn-sm">Read →</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{ $resources->withQueryString()->links() }}
        @else
        <div style="text-align:center;padding:80px 0;"><svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 16px;display:block;color:var(--border);"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg><h3>No articles found</h3></div>
        @endif
    </div>
</div>
@endsection
