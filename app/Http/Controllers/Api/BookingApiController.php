<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TherapistProfile;
use App\Models\Booking;
use App\Models\TherapySession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;

class BookingApiController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('patient_id', Auth::id())
            ->with('session.therapist')
            ->latest()
            ->get();

        return response()->json(['success' => true, 'data' => $bookings]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'therapist_id'  => ['required', 'exists:therapist_profiles,id'],
            'scheduled_at'  => ['required', 'date', 'after:now'],
            'session_type'  => ['required', 'in:video,audio,chat'],
        ]);

        $therapist = TherapistProfile::findOrFail($validated['therapist_id']);

        $session = TherapySession::create([
            'patient_id'   => Auth::id(),
            'therapist_id' => $therapist->user_id,
            'scheduled_at' => $validated['scheduled_at'],
            'session_type' => $validated['session_type'],
            'status'       => 'pending',
        ]);

        $api   = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
        $order = $api->order->create([
            'receipt'         => 'booking_' . $session->id,
            'amount'          => $therapist->hourly_rate * 100,
            'currency'        => 'INR',
            'payment_capture' => 1,
        ]);

        $booking = Booking::create([
            'session_id'        => $session->id,
            'patient_id'        => Auth::id(),
            'amount'            => $therapist->hourly_rate,
            'payment_status'    => 'pending',
            'razorpay_order_id' => $order->id,
        ]);

        return response()->json([
            'success'  => true,
            'data'     => $booking,
            'order_id' => $order->id,
            'amount'   => $therapist->hourly_rate * 100,
            'currency' => 'INR',
        ], 201);
    }
}
