<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapySession extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id', 'therapist_id', 'scheduled_at', 'duration_minutes',
        'status', 'meeting_link', 'session_type', 'patient_notes',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'duration_minutes' => 'integer',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function therapist()
    {
        return $this->belongsTo(User::class, 'therapist_id');
    }

    public function booking()
    {
        return $this->hasOne(Booking::class, 'session_id');
    }

    public function notes()
    {
        return $this->hasMany(SessionNote::class, 'session_id');
    }

    public function isPending(): bool    { return $this->status === 'pending'; }
    public function isConfirmed(): bool  { return $this->status === 'confirmed'; }
    public function isCompleted(): bool  { return $this->status === 'completed'; }
    public function isCancelled(): bool  { return $this->status === 'cancelled'; }
    public function isRejected(): bool   { return $this->status === 'rejected'; }
    public function isActive(): bool     { return in_array($this->status, ['pending', 'confirmed']); }
}
