<?php

namespace App\Http\Controllers;

use App\Models\TherapistProfile;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    public function index()
    {
        $therapists = TherapistProfile::with('user')
            ->where('is_verified', true)
            ->where('is_available', true)
            ->orderByDesc('rating')
            ->take(6)
            ->get();

        $articles = Resource::published()
            ->with('author')
            ->latest('published_at')
            ->take(3)
            ->get();

        $stats = [
            'therapists' => TherapistProfile::where('is_verified', true)->count(),
            'patients'   => \App\Models\User::where('role', 'patient')->count(),
            'sessions'   => \App\Models\TherapySession::where('status', 'completed')->count(),
        ];

        return view('home', compact('therapists', 'articles', 'stats'));
    }

    public function setLocale(Request $request)
    {
        $locale = $request->input('locale', 'en');
        if (in_array($locale, ['en', 'hi'])) {
            session(['locale' => $locale]);
            if (auth()->check()) {
                auth()->user()->update(['locale' => $locale]);
            }
        }
        return redirect()->back()->withCookie(cookie('locale', $locale, 60 * 24 * 30));
    }
}
