<?php

namespace App\Http\Controllers;

use App\Models\TherapistProfile;
use Illuminate\Http\Request;

class TherapistController extends Controller
{
    public function index(Request $request)
    {
        $query = TherapistProfile::with('user')
            ->where('is_verified', true);

        if ($request->filled('specialty')) {
            $query->where('specialty', $request->specialty);
        }

        if ($request->filled('max_rate')) {
            $query->where('hourly_rate', '<=', $request->max_rate);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('specialty', 'like', "%{$search}%")
              ->orWhere('bio', 'like', "%{$search}%");
        }

        $therapists = $query->orderByDesc('rating')->paginate(9);
        $specialties = TherapistProfile::distinct()->pluck('specialty')->sort()->values();

        return view('therapists.index', compact('therapists', 'specialties'));
    }

    public function show(TherapistProfile $therapist)
    {
        $therapist->load('user');
        $reviews = $therapist->sessions()
            ->where('status', 'completed')
            ->with('patient')
            ->latest()
            ->take(5)
            ->get();

        return view('therapists.show', compact('therapist', 'reviews'));
    }
}
