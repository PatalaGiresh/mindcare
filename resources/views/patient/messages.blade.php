@extends('layouts.app')
@section('title', 'Messages')
@section('content')
<h1 style="font-size:1.6rem;margin-bottom:24px;">Messages</h1>

<div style="display:grid;grid-template-columns:280px 1fr;gap:0;border:1px solid var(--border-light);border-radius:var(--radius-md);overflow:hidden;background:var(--card);min-height:500px;">
    {{-- Conversations list --}}
    <div style="border-right:1px solid var(--border-light);overflow-y:auto;">
        <div style="padding:16px;border-bottom:1px solid var(--border-light);font-weight:600;font-size:0.875rem;color:var(--text-muted);">CONVERSATIONS</div>
        @forelse($conversations as $partnerId => $msgs)
            @php $lastMsg = $msgs->first(); $convPartner = $lastMsg->sender_id === auth()->id() ? $lastMsg->receiver : $lastMsg->sender; @endphp
            <a href="{{ route('messages.index', ['with' => $partnerId]) }}" style="display:flex;align-items:center;gap:12px;padding:14px 16px;border-bottom:1px solid var(--border-light);text-decoration:none;{{ $partner && $partner->id == $partnerId ? 'background:rgba(45,106,106,0.08);' : '' }}">
                <div class="therapist-avatar" style="width:40px;height:40px;font-size:0.9rem;flex-shrink:0;">{{ strtoupper(substr($convPartner->name,0,1)) }}</div>
                <div style="flex:1;overflow:hidden;">
                    <div style="font-weight:600;font-size:0.875rem;color:var(--text-primary);">{{ $convPartner->name }}</div>
                    <div style="font-size:0.78rem;color:var(--text-muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Str::limit($lastMsg->body, 35) }}</div>
                </div>
            </a>
        @empty
        <div style="padding:32px;text-align:center;color:var(--text-muted);font-size:0.875rem;">No conversations yet</div>
        @endforelse
    </div>

    {{-- Chat area --}}
    <div style="display:flex;flex-direction:column;">
        @if($partner)
        <div style="padding:16px 20px;border-bottom:1px solid var(--border-light);display:flex;align-items:center;gap:12px;">
            <div class="therapist-avatar" style="width:36px;height:36px;font-size:0.85rem;">{{ strtoupper(substr($partner->name,0,1)) }}</div>
            <div style="font-weight:600;">{{ $partner->name }}</div>
        </div>
        <div style="flex:1;padding:20px;overflow-y:auto;display:flex;flex-direction:column;gap:12px;max-height:400px;">
            @foreach($messages as $msg)
            <div style="display:flex;{{ $msg->sender_id===auth()->id() ? 'justify-content:flex-end;' : '' }}">
                <div class="message-bubble {{ $msg->sender_id===auth()->id() ? 'message-sent' : 'message-received' }}">
                    {{ $msg->body }}
                    <div style="font-size:0.7rem;opacity:0.7;margin-top:4px;text-align:right;">{{ $msg->created_at->format('g:i A') }}</div>
                </div>
            </div>
            @endforeach
        </div>
        <div style="padding:16px 20px;border-top:1px solid var(--border-light);">
            <form method="POST" action="{{ route('messages.store') }}" style="display:flex;gap:10px;">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $partner->id }}">
                <input type="text" name="body" class="form-control" placeholder="Type a message..." required style="flex:1;">
                <button type="submit" class="btn btn-primary">Send</button>
            </form>
        </div>
        @else
        <div style="display:flex;align-items:center;justify-content:center;flex:1;color:var(--text-muted);">
            <div style="text-align:center;"><div style="font-size:2.5rem;margin-bottom:12px;">💬</div><p>Select a conversation to start messaging</p></div>
        </div>
        @endif
    </div>
</div>
@endsection
