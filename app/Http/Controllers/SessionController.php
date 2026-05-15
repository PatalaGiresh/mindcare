<?php

namespace App\Http\Controllers;

use App\Models\TherapySession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function index(Request $request)
    {
        $user  = Auth::user();
        $query = TherapySession::where('therapist_id', $user->id)->with('patient');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sessions = $query->orderByDesc('scheduled_at')->paginate(10);
        return view('therapist.sessions.index', compact('sessions'));
    }

    public function show(TherapySession $session)
    {
        abort_if($session->therapist_id !== Auth::id(), 403);
        $session->load('patient', 'notes', 'booking');
        return view('therapist.sessions.show', compact('session'));
    }

    public function updateStatus(Request $request, TherapySession $session)
    {
        abort_if($session->therapist_id !== Auth::id(), 403);

        $request->validate([
            'status' => 'required|in:confirmed,completed,rejected',
        ]);

        $session->update(['status' => $request->status]);

        $message = match($request->status) {
            'confirmed' => 'Session confirmed successfully.',
            'completed' => 'Session marked as completed.',
            'rejected'  => 'Session request rejected.',
        };

        return back()->with('success', $message);
    }

    public function updateMeetingLink(Request $request, TherapySession $session)
    {
        abort_if($session->therapist_id !== Auth::id(), 403);
        abort_if($session->status !== 'confirmed', 403);

        $request->validate([
            'meeting_link' => ['required', 'url', 'max:500'],
        ]);

        $session->update(['meeting_link' => $request->meeting_link]);

        return back()->with('success', 'Meeting link updated. Patient can now see it on their dashboard.');
    }
}
