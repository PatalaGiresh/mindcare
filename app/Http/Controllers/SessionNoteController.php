<?php

namespace App\Http\Controllers;

use App\Models\SessionNote;
use App\Models\TherapySession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionNoteController extends Controller
{
    public function store(Request $request, TherapySession $session)
    {
        abort_if($session->therapist_id !== Auth::id(), 403);

        $request->validate([
            'content'    => ['required', 'string', 'min:10', 'max:5000'],
            'is_private' => ['boolean'],
        ]);

        SessionNote::create([
            'session_id'  => $session->id,
            'therapist_id'=> Auth::id(),
            'content'     => $request->content,
            'is_private'  => $request->boolean('is_private', true),
        ]);

        return back()->with('success', 'Note saved successfully.');
    }
}
