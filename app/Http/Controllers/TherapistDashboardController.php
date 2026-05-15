<?php

namespace App\Http\Controllers;

use App\Models\TherapySession;
use Illuminate\Support\Facades\Auth;

class TherapistDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Pending requests — need therapist action
        $pendingRequests = TherapySession::where('therapist_id', $user->id)
            ->where('status', 'pending')
            ->with('patient')
            ->orderBy('scheduled_at')
            ->take(5)
            ->get();

        // Upcoming confirmed sessions
        $upcomingSessions = TherapySession::where('therapist_id', $user->id)
            ->where('status', 'confirmed')
            ->where('scheduled_at', '>=', now())
            ->with('patient')
            ->orderBy('scheduled_at')
            ->take(5)
            ->get();

        // Recent completed sessions
        $recentSessions = TherapySession::where('therapist_id', $user->id)
            ->where('status', 'completed')
            ->with('patient')
            ->latest('scheduled_at')
            ->take(5)
            ->get();

        $totalPatients  = TherapySession::where('therapist_id', $user->id)
            ->distinct('patient_id')->count('patient_id');
        $totalCompleted = TherapySession::where('therapist_id', $user->id)
            ->where('status', 'completed')->count();
        $pendingCount   = TherapySession::where('therapist_id', $user->id)
            ->where('status', 'pending')->count();

        return view('therapist.dashboard', compact(
            'user', 'pendingRequests', 'upcomingSessions', 'recentSessions',
            'totalPatients', 'totalCompleted', 'pendingCount'
        ));
    }
}
