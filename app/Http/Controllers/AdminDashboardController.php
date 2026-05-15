<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TherapistProfile;
use App\Models\TherapySession;
use App\Models\User;
use App\Models\Resource;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'        => User::count(),
            'total_patients'     => User::where('role', 'patient')->count(),
            'total_therapists'   => User::where('role', 'therapist')->count(),
            'pending_therapists' => TherapistProfile::where('is_verified', false)->count(),
            'total_sessions'     => TherapySession::count(),
            'pending_sessions'   => TherapySession::where('status', 'pending')->count(),
            'total_revenue'      => Booking::where('payment_status', 'paid')->sum('amount'),
            'total_resources'    => Resource::count(),
        ];

        $recentUsers    = User::latest()->take(5)->get();
        $recentBookings = Booking::with('patient', 'session.therapist')->latest()->take(5)->get();

        $monthlyRevenue = Booking::where('payment_status', 'paid')
            ->selectRaw('MONTH(paid_at) as month, SUM(amount) as total')
            ->whereYear('paid_at', now()->year)
            ->groupBy('month')->orderBy('month')->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentBookings', 'monthlyRevenue'));
    }
}
