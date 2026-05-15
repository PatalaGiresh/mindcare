<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'avatar',
        'phone', 'date_of_birth', 'gender', 'locale',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'password' => 'hashed',
    ];

    // Role helpers
    public function isAdmin(): bool    { return $this->role === 'admin'; }
    public function isTherapist(): bool { return $this->role === 'therapist'; }
    public function isPatient(): bool   { return $this->role === 'patient'; }

    // Relationships
    public function therapistProfile()
    {
        return $this->hasOne(TherapistProfile::class);
    }

    public function moodLogs()
    {
        return $this->hasMany(MoodLog::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'patient_id');
    }

    public function patientSessions()
    {
        return $this->hasMany(TherapySession::class, 'patient_id');
    }

    public function therapistSessions()
    {
        return $this->hasMany(TherapySession::class, 'therapist_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function resources()
    {
        return $this->hasMany(Resource::class, 'author_id');
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : asset('images/default-avatar.png');
    }
}
