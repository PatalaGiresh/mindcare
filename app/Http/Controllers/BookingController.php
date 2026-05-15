<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TherapistProfile;
use App\Models\TherapySession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('patient_id', Auth::id())
            ->with('session.therapist.therapistProfile')
            ->latest()
            ->paginate(10);

        return view('patient.bookings.index', compact('bookings'));
    }

    public function create(Request $request)
    {
        $therapist = TherapistProfile::with('user')->findOrFail($request->therapist_id);
        return view('patient.bookings.create', compact('therapist'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'therapist_id'  => ['required', 'exists:therapist_profiles,id'],
            'scheduled_at'  => ['required', 'date', 'after:now'],
            'session_type'  => ['required', 'in:video,audio,chat'],
            'patient_notes' => ['nullable', 'string', 'max:500'],
        ]);

        $therapist = TherapistProfile::findOrFail($validated['therapist_id']);

        // Session starts as PENDING — therapist must confirm or reject
        $session = TherapySession::create([
            'patient_id'    => Auth::id(),
            'therapist_id'  => $therapist->user_id,
            'scheduled_at'  => $validated['scheduled_at'],
            'session_type'  => $validated['session_type'],
            'patient_notes' => $validated['patient_notes'] ?? null,
            'status'        => 'pending',
        ]);

        Booking::create([
            'session_id'     => $session->id,
            'patient_id'     => Auth::id(),
            'amount'         => $therapist->hourly_rate,
            'payment_status' => 'paid',
            'paid_at'        => now(),
        ]);

        return redirect()->route('patient.bookings.index')
            ->with('success', 'Session request sent! Waiting for therapist confirmation.');
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        $booking->load('session.therapist.therapistProfile');
        return view('patient.bookings.show', compact('booking'));
    }

    public function destroy(Booking $booking)
    {
        $this->authorize('delete', $booking);

        // Allow cancellation only within 1 hour of booking creation
        if ($booking->created_at->diffInMinutes(now()) > 60) {
            return back()->with('error', 'Cancellation window has passed. Bookings can only be cancelled within 1 hour of booking.');
        }

        if (!in_array($booking->session->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'This session cannot be cancelled.');
        }

        $booking->session->update(['status' => 'cancelled']);
        $booking->update(['payment_status' => 'refunded']);

        return redirect()->route('patient.bookings.index')
            ->with('success', 'Booking cancelled successfully.');
    }
}
