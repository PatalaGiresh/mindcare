@extends('layouts.app')
@section('title', 'Session Details')
@section('content')
<div class="mb-24"><a href="{{ route('therapist.sessions.index') }}" style="font-size:0.875rem;color:var(--text-muted);">← Back to Sessions</a></div>

<div style="display:grid;grid-template-columns:1fr 360px;gap:24px;align-items:start;">
    <div>
        {{-- Main session card --}}
        <div class="card mb-24">
            <div class="card-header d-flex justify-between align-center">
                <h1 style="font-size:1.2rem;">Session with {{ $session->patient->name }}</h1>
                <span class="badge {{ match($session->status) {
                    'confirmed'  => 'badge-success',
                    'completed'  => 'badge-primary',
                    'pending'    => 'badge-warning',
                    'rejected'   => 'badge-danger',
                    'cancelled'  => 'badge-danger',
                    default      => 'badge-muted'
                } }}">{{ ucfirst($session->status) }}</span>
            </div>
            <div class="card-body">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">
                    <div><div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:4px;">PATIENT</div><div style="font-weight:600;">{{ $session->patient->name }}</div></div>
                    <div><div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:4px;">DATE & TIME</div><div style="font-weight:600;">{{ $session->scheduled_at->format('D, M j, Y g:i A') }}</div></div>
                    <div><div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:4px;">SESSION TYPE</div><div style="font-weight:600;">{{ ucfirst($session->session_type) }}</div></div>
                    <div><div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:4px;">BOOKED ON</div><div style="font-weight:600;">{{ $session->created_at->format('M j, Y') }}</div></div>
                </div>

                @if($session->patient_notes)
                <div style="background:var(--surface);border-radius:var(--radius-sm);padding:14px;margin-bottom:20px;">
                    <div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:6px;">PATIENT NOTES</div>
                    <p style="font-size:0.875rem;color:var(--text-secondary);">{{ $session->patient_notes }}</p>
                </div>
                @endif

                {{-- PENDING: Confirm or Reject --}}
                @if($session->isPending())
                <div style="padding:16px;background:rgba(245,158,11,0.06);border:1px solid rgba(245,158,11,0.2);border-radius:var(--radius-sm);margin-bottom:16px;">
                    <div style="font-weight:600;margin-bottom:12px;">Action Required — Review this booking request</div>
                    <div class="d-flex gap-12">
                        <form method="POST" action="{{ route('therapist.sessions.status', $session) }}" style="flex:1;">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="confirmed">
                            <button type="submit" class="btn btn-primary btn-block">Confirm Session</button>
                        </form>
                        <form method="POST" action="{{ route('therapist.sessions.status', $session) }}" style="flex:1;" onsubmit="return confirm('Reject this session request?')">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="btn btn-danger btn-block">Reject Request</button>
                        </form>
                    </div>
                </div>
                @endif

                {{-- CONFIRMED: Meeting link + Mark Completed --}}
                @if($session->isConfirmed())
                <div style="padding:16px;background:rgba(45,106,106,0.06);border:1px solid rgba(45,106,106,0.15);border-radius:var(--radius-sm);margin-bottom:16px;">
                    <div style="font-weight:600;margin-bottom:12px;">Session Confirmed</div>

                    {{-- Meeting link form --}}
                    <form method="POST" action="{{ route('therapist.sessions.meeting-link', $session) }}" style="margin-bottom:16px;">
                        @csrf @method('PATCH')
                        <label class="form-label">Google Meet / Zoom Link <span style="font-size:0.75rem;color:var(--text-muted);">(shared with patient)</span></label>
                        <div style="display:flex;gap:10px;">
                            <input type="url" name="meeting_link" class="form-control" placeholder="https://meet.google.com/..." value="{{ $session->meeting_link }}" style="flex:1;">
                            <button type="submit" class="btn btn-primary">{{ $session->meeting_link ? 'Update Link' : 'Share Link' }}</button>
                        </div>
                        @if($session->meeting_link)
                        <div style="margin-top:6px;font-size:0.78rem;color:var(--success);">Link shared with patient: <a href="{{ $session->meeting_link }}" target="_blank" style="color:var(--primary);">{{ Str::limit($session->meeting_link, 50) }}</a></div>
                        @endif
                    </form>

                    {{-- Mark Completed --}}
                    <form method="POST" action="{{ route('therapist.sessions.status', $session) }}" onsubmit="return confirm('Mark this session as completed?')">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="btn btn-outline">Mark Session as Completed</button>
                    </form>
                </div>
                @endif

                {{-- COMPLETED banner --}}
                @if($session->isCompleted())
                <div style="padding:16px;background:rgba(61,139,110,0.08);border:1px solid rgba(61,139,110,0.2);border-radius:var(--radius-sm);margin-bottom:16px;">
                    <div style="font-weight:600;color:var(--success);margin-bottom:4px;">Session Completed</div>
                    <div style="font-size:0.82rem;color:var(--text-muted);">This session has been completed. You can still add notes below.</div>
                </div>
                @endif

                {{-- REJECTED banner --}}
                @if($session->isRejected())
                <div style="padding:16px;background:rgba(192,80,74,0.08);border:1px solid rgba(192,80,74,0.2);border-radius:var(--radius-sm);margin-bottom:16px;">
                    <div style="font-weight:600;color:var(--danger);margin-bottom:4px;">Session Rejected</div>
                    <div style="font-size:0.82rem;color:var(--text-muted);">You rejected this booking request.</div>
                </div>
                @endif

                {{-- CANCELLED banner --}}
                @if($session->isCancelled())
                <div style="padding:16px;background:rgba(192,80,74,0.08);border:1px solid rgba(192,80,74,0.2);border-radius:var(--radius-sm);margin-bottom:16px;">
                    <div style="font-weight:600;color:var(--danger);margin-bottom:4px;">Session Cancelled</div>
                    <div style="font-size:0.82rem;color:var(--text-muted);">This session was cancelled by the patient.</div>
                </div>
                @endif
            </div>
        </div>

        {{-- Session Notes --}}
        <div class="card">
            <div class="card-header"><h2 style="font-size:1.05rem;">Session Notes</h2></div>
            <div class="card-body">
                <form method="POST" action="{{ route('therapist.sessions.notes.store', $session) }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Add a Note</label>
                        <textarea name="content" class="form-control" rows="4" placeholder="Write session observations, treatment plan, follow-up actions..."></textarea>
                        @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-check">
                            <input type="checkbox" name="is_private" value="1" class="form-check-input" checked>
                            <span style="font-size:0.875rem;">Private note (not visible to patient)</span>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Note</button>
                </form>
                @if($session->notes->count() > 0)
                <div style="margin-top:24px;border-top:1px solid var(--border-light);padding-top:20px;">
                    @foreach($session->notes->sortByDesc('created_at') as $note)
                    <div style="padding:14px;background:var(--surface);border-radius:var(--radius-sm);margin-bottom:12px;">
                        <div class="d-flex justify-between mb-8">
                            <span style="font-size:0.78rem;color:var(--text-muted);">{{ $note->created_at->format('M j, Y g:i A') }}</span>
                            @if($note->is_private)<span class="badge badge-warning" style="font-size:0.7rem;">Private</span>@else<span class="badge badge-success" style="font-size:0.7rem;">Shared</span>@endif
                        </div>
                        <p style="font-size:0.875rem;color:var(--text-secondary);line-height:1.65;">{{ $note->content }}</p>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div style="position:sticky;top:88px;">
        <div class="card mb-16">
            <div class="card-body">
                <h2 style="font-size:1rem;margin-bottom:16px;">Patient Contact</h2>
                <div style="font-weight:600;margin-bottom:4px;">{{ $session->patient->name }}</div>
                <div style="font-size:0.875rem;color:var(--text-muted);margin-bottom:16px;">{{ $session->patient->email }}</div>
                <a href="{{ route('messages.index', ['with' => $session->patient_id]) }}" class="btn btn-outline btn-block btn-sm">Send Message</a>
            </div>
        </div>
    </div>
</div>
@endsection
