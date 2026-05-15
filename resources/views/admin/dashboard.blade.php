@extends('layouts.app')
@section('title', 'Admin Dashboard')
@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endpush
@section('content')
<h1 style="font-size:1.6rem;margin-bottom:4px;">Admin Dashboard</h1>
<p style="color:var(--text-muted);margin-bottom:32px;">Platform overview and management</p>

<div class="grid-4 mb-32">
    <div class="stat-card">
        <div class="stat-icon stat-icon-teal"><svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
        <div class="stat-number">{{ $stats['total_users'] }}</div>
        <div class="stat-label">Total Users</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-icon-accent"><svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg></div>
        <div class="stat-number">{{ $stats['total_therapists'] }}</div>
        <div class="stat-label">Therapists</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-icon-green"><svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
        <div class="stat-number">{{ $stats['total_sessions'] }}</div>
        <div class="stat-label">Total Sessions</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-icon-warm"><svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
        <div class="stat-number">₹{{ number_format($stats['total_revenue']) }}</div>
        <div class="stat-label">Total Revenue</div>
    </div>
</div>

@if($stats['pending_therapists'] > 0)
<div class="alert alert-warning mb-24">
    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
    <span><strong>{{ $stats['pending_therapists'] }} therapist(s)</strong> awaiting verification. <a href="{{ route('admin.users.index', ['role'=>'therapist']) }}" style="font-weight:600;">Review now →</a></span>
</div>
@endif

<div style="display:grid;grid-template-columns:2fr 1fr;gap:24px;">
    <div>
        <div class="mood-chart-container mb-24">
            <h2 style="font-size:1.05rem;margin-bottom:20px;">Monthly Revenue — {{ date('Y') }}</h2>
            <canvas id="revenueChart" height="100"></canvas>
        </div>
        <div class="card">
            <div class="card-header"><h2 style="font-size:1.05rem;">Recent Bookings</h2></div>
            <div class="table-wrapper">
                <table>
                    <thead><tr><th>Patient</th><th>Therapist</th><th>Amount</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse($recentBookings as $b)
                        <tr>
                            <td>{{ $b->patient->name }}</td>
                            <td>{{ optional($b->session->therapist)->name ?? '—' }}</td>
                            <td>₹{{ number_format($b->amount) }}</td>
                            <td><span class="badge {{ $b->isPaid()?'badge-success':'badge-warning' }}">{{ ucfirst($b->payment_status) }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="4" style="text-align:center;color:var(--text-muted);">No bookings yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div>
        <div class="card mb-24">
            <div class="card-body">
                <h2 style="font-size:1rem;margin-bottom:16px;">Platform Stats</h2>
                <div style="display:flex;flex-direction:column;gap:14px;">
                    @foreach([['label'=>'Patients','value'=>$stats['total_patients'],'color'=>'var(--primary)'],['label'=>'Verified Therapists','value'=>$stats['total_therapists']-$stats['pending_therapists'],'color'=>'var(--success)'],['label'=>'Pending Verification','value'=>$stats['pending_therapists'],'color'=>'var(--warning)'],['label'=>'Pending Sessions','value'=>$stats['pending_sessions'],'color'=>'var(--accent)'],['label'=>'Resources Published','value'=>$stats['total_resources'],'color'=>'var(--primary)']] as $item)
                    <div class="d-flex justify-between align-center">
                        <span style="font-size:0.875rem;color:var(--text-muted);">{{ $item['label'] }}</span>
                        <span style="font-weight:700;color:{{ $item['color'] }};">{{ $item['value'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header d-flex justify-between align-center">
                <h2 style="font-size:1rem;">New Users</h2>
                <a href="{{ route('admin.users.index') }}" style="font-size:0.82rem;color:var(--primary);">All →</a>
            </div>
            <div class="card-body p-0">
                @foreach($recentUsers as $u)
                <div style="padding:12px 20px;border-bottom:1px solid var(--border-light);display:flex;align-items:center;gap:12px;">
                    <div class="therapist-avatar" style="width:34px;height:34px;font-size:0.8rem;flex-shrink:0;">{{ strtoupper(substr($u->name,0,1)) }}</div>
                    <div style="flex:1;"><div style="font-weight:600;font-size:0.85rem;">{{ $u->name }}</div><div style="font-size:0.75rem;color:var(--text-muted);">{{ $u->email }}</div></div>
                    <span class="badge badge-muted" style="font-size:0.7rem;text-transform:capitalize;">{{ $u->role }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
const revenueData = Array(12).fill(0);
@foreach($monthlyRevenue as $row) revenueData[{{ $row->month - 1 }}] = {{ $row->total }}; @endforeach
new Chart(document.getElementById('revenueChart').getContext('2d'), {
    type:'bar',
    data:{ labels:['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'], datasets:[{label:'Revenue (₹)',data:revenueData,backgroundColor:'rgba(45,106,106,0.7)',borderRadius:6}] },
    options:{ responsive:true, plugins:{legend:{display:false}}, scales:{ y:{beginAtZero:true,grid:{color:'rgba(0,0,0,0.04)'}}, x:{grid:{display:false}} } }
});
</script>
@endpush
