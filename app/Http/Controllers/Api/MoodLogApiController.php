<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MoodLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MoodLogApiController extends Controller
{
    public function index()
    {
        $logs = MoodLog::where('user_id', Auth::id())
            ->latest('logged_at')
            ->take(30)
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $logs,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'score'   => ['required', 'integer', 'min:1', 'max:10'],
            'emotion' => ['required', 'string', 'max:50'],
            'tags'    => ['nullable', 'array'],
            'note'    => ['nullable', 'string', 'max:500'],
        ]);

        $validated['user_id']   = Auth::id();
        $validated['logged_at'] = now();

        $log = MoodLog::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Mood logged successfully.',
            'data'    => $log,
        ], 201);
    }
}
