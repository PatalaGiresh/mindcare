@extends('layouts.app')
@section('title', 'User Management')
@section('content')
<div class="d-flex justify-between align-center mb-32">
    <div><h1 style="font-size:1.6rem;margin-bottom:4px;">User Management</h1><p style="color:var(--text-muted);">Manage all platform users</p></div>
</div>

<div class="card mb-24" style="padding:16px 24px;">
    <form method="GET" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
        <div>
            <label class="form-label">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or email..." class="form-control" style="max-width:240px;">
        </div>
        <div>
            <label class="form-label">Role</label>
            <select name="role" class="form-control form-select" style="max-width:160px;">
                <option value="">All Roles</option>
                <option value="patient" {{ request('role')==='patient'?'selected':'' }}>Patient</option>
                <option value="therapist" {{ request('role')==='therapist'?'selected':'' }}>Therapist</option>
                <option value="admin" {{ request('role')==='admin'?'selected':'' }}>Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
        @if(request()->hasAny(['search','role']))<a href="{{ route('admin.users.index') }}" class="btn btn-ghost">Clear</a>@endif
    </form>
</div>

<div class="table-wrapper">
    <table>
        <thead>
            <tr><th>User</th><th>Email</th><th>Role</th><th>Joined</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>
                    <div class="d-flex align-center gap-12">
                        <div class="therapist-avatar" style="width:36px;height:36px;font-size:0.85rem;flex-shrink:0;">{{ strtoupper(substr($user->name,0,1)) }}</div>
                        <div>
                            <div style="font-weight:600;font-size:0.9rem;">{{ $user->name }}</div>
                            @if($user->isTherapist() && $user->therapistProfile)
                                <div style="font-size:0.75rem;color:var(--text-muted);">{{ $user->therapistProfile->specialty }}</div>
                            @endif
                        </div>
                    </div>
                </td>
                <td style="color:var(--text-muted);">{{ $user->email }}</td>
                <td>
                    <span class="badge {{ $user->isAdmin()?'badge-danger':($user->isTherapist()?'badge-info':'badge-primary') }}">{{ ucfirst($user->role) }}</span>
                    @if($user->isTherapist() && $user->therapistProfile && !$user->therapistProfile->is_verified)
                        <span class="badge badge-warning mt-4" style="display:block;margin-top:4px;">Unverified</span>
                    @endif
                </td>
                <td style="color:var(--text-muted);font-size:0.875rem;">{{ $user->created_at->format('M j, Y') }}</td>
                <td>
                    <div class="d-flex gap-8" style="flex-wrap:wrap;">
                        @if($user->isTherapist() && $user->therapistProfile && !$user->therapistProfile->is_verified)
                        <form method="POST" action="{{ route('admin.users.verify-therapist',$user) }}">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">✓ Verify</button>
                        </form>
                        @endif
                        @if(!$user->isAdmin())
                        <form method="POST" action="{{ route('admin.users.destroy',$user) }}" onsubmit="return confirm('Delete {{ $user->name }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;padding:40px;color:var(--text-muted);">No users found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($users->hasPages())<div style="margin-top:16px;">{{ $users->links() }}</div>@endif
@endsection
