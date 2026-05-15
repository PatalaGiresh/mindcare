<?php

namespace App\Http\Controllers;

use App\Models\MoodLog;
use App\Models\TherapySession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Last 7 mood logs for chart
        $moodLogs = MoodLog::where('user_id', $user->id)
            ->latest('logged_at')
            ->take(7)
            ->get()
            ->reverse()
            ->values();

        $upcomingSessions = TherapySession::where('patient_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('scheduled_at', '>=', now())
            ->with('therapist.therapistProfile')
            ->orderBy('scheduled_at')
            ->take(3)
            ->get();

        $totalSessions   = TherapySession::where('patient_id', $user->id)->count();
        $completedCount  = TherapySession::where('patient_id', $user->id)->where('status', 'completed')->count();
        $avgMood         = MoodLog::where('user_id', $user->id)->avg('score') ?? 0;
        $unreadMessages  = \App\Models\Message::where('receiver_id', $user->id)->whereNull('read_at')->count();

        return view('patient.dashboard', compact(
            'user', 'moodLogs', 'upcomingSessions',
            'totalSessions', 'completedCount', 'avgMood', 'unreadMessages'
        ));
    }
}
