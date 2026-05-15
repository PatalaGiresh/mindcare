@extends('layouts.app')
@section('title', 'My Sessions')
@section('content')
<div class="d-flex justify-between align-center mb-32">
    <div><h1 style="font-size:1.6rem;margin-bottom:4px;">My Sessions</h1><p style="color:var(--text-muted);">All therapy sessions assigned to you</p></div>
    <div>
        <form method="GET" style="display:flex;gap:10px;">
            <select name="status" class="form-control form-select" onchange="this.form.submit()" style="max-width:180px;">
                <option value="">All Status</option>
                @foreach(['pending','confirmed','completed','rejected','cancelled'] as $s)
                <option value="{{ $s }}" {{ request('status')===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </form>
    </div>
</div>

<div class="card">
    @forelse($sessions as $session)
    <div style="padding:20px 24px;border-bottom:1px solid var(--border-light);">
        <div class="d-flex align-center gap-16">
            <div class="therapist-avatar" style="width:46px;height:46px;font-size:1rem;flex-shrink:0;">{{ strtoupper(substr($session->patient->name,0,1)) }}</div>
            <div style="flex:1;">
                <div style="font-weight:700;">{{ $session->patient->name }}</div>
                <div style="font-size:0.82rem;color:var(--text-muted);">{{ $session->patient->email }}</div>
                <div style="font-size:0.82rem;color:var(--text-muted);margin-top:4px;">
                    {{ $session->scheduled_at->format('D, M j, Y \a\t g:i A') }} &bull; {{ ucfirst($session->session_type) }}
                </div>
                @if($session->isPending())
                <div style="margin-top:4px;font-size:0.75rem;color:var(--warning);">Action required — confirm or reject this request</div>
                @elseif($session->isConfirmed() && !$session->meeting_link)
                <div style="margin-top:4px;font-size:0.75rem;color:var(--text-muted);">Meeting link not set yet</div>
                @elseif($session->isConfirmed() && $session->meeting_link)
                <div style="margin-top:4px;font-size:0.75rem;color:var(--success);">Meeting link shared with patient</div>
                @endif
            </div>
            <div style="text-align:right;flex-shrink:0;">
                <span class="badge {{ match($session->status) {
                    'confirmed'  => 'badge-success',
                    'pending'    => 'badge-warning',
                    'completed'  => 'badge-primary',
                    'cancelled'  => 'badge-danger',
                    'rejected'   => 'badge-danger',
                    default      => 'badge-muted'
                } }}">{{ ucfirst($session->status) }}</span>
                <div class="mt-8">
                    @if($session->isPending())
                    <a href="{{ route('therapist.sessions.show', $session) }}" class="btn btn-primary btn-sm">Review</a>
                    @elseif($session->isConfirmed())
                    <a href="{{ route('therapist.sessions.show', $session) }}" class="btn btn-primary btn-sm">Manage</a>
                    @else
                    <a href="{{ route('therapist.sessions.show', $session) }}" class="btn btn-ghost btn-sm">View Details</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div style="text-align:center;padding:60px;">
        <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 16px;display:block;color:var(--border);"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        <h3>No sessions found</h3>
    </div>
    @endforelse
    @if($sessions->hasPages())<div style="padding:16px 24px;">{{ $sessions->links() }}</div>@endif
</div>
@endsection
