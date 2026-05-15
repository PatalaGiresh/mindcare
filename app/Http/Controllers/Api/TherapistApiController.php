<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TherapistProfile;
use Illuminate\Http\Request;

class TherapistApiController extends Controller
{
    public function index(Request $request)
    {
        $query = TherapistProfile::with('user')->where('is_verified', true);

        if ($request->filled('specialty')) {
            $query->where('specialty', $request->specialty);
        }

        $therapists = $query->orderByDesc('rating')->paginate(10);

        return response()->json(['success' => true, 'data' => $therapists]);
    }

    public function show(TherapistProfile $therapist)
    {
        $therapist->load('user');
        return response()->json(['success' => true, 'data' => $therapist]);
    }
}
