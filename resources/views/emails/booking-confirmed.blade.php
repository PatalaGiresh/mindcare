<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Session Confirmed — MindCare</title></head>
<body style="font-family:'DM Sans',sans-serif;background:#F7F4EF;margin:0;padding:24px;">
<div style="max-width:540px;margin:0 auto;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.1);">
    <div style="background:linear-gradient(135deg,#1E4D4D,#2D6A6A);padding:32px;text-align:center;">
        <div style="font-family:'Georgia',serif;font-size:1.6rem;font-weight:700;color:#fff;">Mind<span style="color:#B3AAED">Care</span></div>
        <div style="font-size:2.5rem;margin-top:12px;">&#10003;</div>
        <h1 style="color:#fff;font-size:1.3rem;margin-top:10px;">Session Confirmed!</h1>
    </div>
    <div style="padding:32px;">
        <p style="color:#3D5460;margin-bottom:24px;">Hi <strong>{{ $booking->patient->name }}</strong>,</p>
        <p style="color:#3D5460;line-height:1.7;margin-bottom:24px;">Your therapy session has been booked and payment confirmed. Here are your session details:</p>
        <div style="background:#F7F4EF;border-radius:10px;padding:20px;margin-bottom:24px;">
            <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #EDE9E0;"><span style="color:#6B7E85;">Therapist</span><span style="font-weight:600;">{{ $booking->session->therapist->name }}</span></div>
            <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #EDE9E0;"><span style="color:#6B7E85;">Date & Time</span><span style="font-weight:600;">{{ $booking->session->scheduled_at->format('D, M j, Y \a\t g:i A') }}</span></div>
            <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #EDE9E0;"><span style="color:#6B7E85;">Session Type</span><span style="font-weight:600;">{{ ucfirst($booking->session->session_type) }}</span></div>
            <div style="display:flex;justify-content:space-between;padding:8px 0;"><span style="color:#6B7E85;">Amount Paid</span><span style="font-weight:700;color:#2D6A6A;">₹{{ number_format($booking->amount) }}</span></div>
        </div>
        <a href="{{ route('patient.bookings.index') }}" style="display:block;background:#2D6A6A;color:#fff;text-align:center;padding:14px;border-radius:10px;font-weight:600;text-decoration:none;">View My Bookings</a>
        <p style="color:#6B7E85;font-size:0.8rem;text-align:center;margin-top:16px;">Questions? Reply to this email or message your therapist directly in the platform.</p>
    </div>
    <div style="background:#F7F4EF;padding:16px;text-align:center;border-top:1px solid #EDE9E0;">
        <p style="color:#6B7E85;font-size:0.75rem;margin:0;">© {{ date('Y') }} MindCare. All rights reserved. | Crisis: iCall 9152987821</p>
    </div>
</div>
</body></html>
