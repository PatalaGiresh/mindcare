<?php

namespace App\Http\Controllers;

use App\Models\MoodLog;
use App\Rules\ValidMoodScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MoodLogController extends Controller
{
    public function index()
    {
        $logs = MoodLog::where('user_id', Auth::id())
            ->latest('logged_at')
            ->paginate(15);

        $chartData = MoodLog::where('user_id', Auth::id())
            ->latest('logged_at')
            ->take(30)
            ->get()
            ->reverse()
            ->values();

        return view('patient.mood.index', compact('logs', 'chartData'));
    }

    public function create()
    {
        $emotions = ['Happy', 'Calm', 'Anxious', 'Sad', 'Angry', 'Hopeful', 'Tired', 'Energetic', 'Stressed', 'Peaceful'];
        $tags = ['Work stress', 'Relationship', 'Sleep issues', 'Physical health', 'Family', 'Financial', 'Loneliness', 'Gratitude'];
        return view('patient.mood.create', compact('emotions', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'score'   => ['required', 'integer', 'min:1', 'max:10'],
            'emotion' => ['required', 'string', 'max:50'],
            'tags'    => ['nullable', 'array'],
            'tags.*'  => ['string', 'max:50'],
            'note'    => ['nullable', 'string', 'max:500'],
        ]);

        $validated['user_id']   = Auth::id();
        $validated['logged_at'] = now();

        MoodLog::create($validated);

        return redirect()->route('patient.mood.index')
            ->with('success', 'Mood logged successfully! Keep tracking your progress.');
    }

    public function show(MoodLog $moodLog)
    {
        $this->authorize('view', $moodLog);
        return view('patient.mood.show', compact('moodLog'));
    }

    public function edit(MoodLog $moodLog)
    {
        $this->authorize('update', $moodLog);
        $emotions = ['Happy', 'Calm', 'Anxious', 'Sad', 'Angry', 'Hopeful', 'Tired', 'Energetic', 'Stressed', 'Peaceful'];
        $tags = ['Work stress', 'Relationship', 'Sleep issues', 'Physical health', 'Family', 'Financial', 'Loneliness', 'Gratitude'];
        return view('patient.mood.edit', compact('moodLog', 'emotions', 'tags'));
    }

    public function update(Request $request, MoodLog $moodLog)
    {
        $this->authorize('update', $moodLog);

        $validated = $request->validate([
            'score'   => ['required', 'integer', 'min:1', 'max:10'],
            'emotion' => ['required', 'string', 'max:50'],
            'tags'    => ['nullable', 'array'],
            'tags.*'  => ['string', 'max:50'],
            'note'    => ['nullable', 'string', 'max:500'],
        ]);

        $moodLog->update($validated);

        return redirect()->route('patient.mood.index')
            ->with('success', 'Mood log updated successfully.');
    }

    public function destroy(MoodLog $moodLog)
    {
        $this->authorize('delete', $moodLog);
        $moodLog->delete();
        return redirect()->route('patient.mood.index')
            ->with('success', 'Mood log deleted.');
    }
}
