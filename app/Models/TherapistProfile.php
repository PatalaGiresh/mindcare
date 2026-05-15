<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapistProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'specialty', 'bio', 'hourly_rate', 'experience_years',
        'qualification', 'languages', 'availability', 'is_verified',
        'is_available', 'rating', 'total_sessions',
    ];

    protected $casts = [
        'availability' => 'array',
        'is_verified' => 'boolean',
        'is_available' => 'boolean',
        'hourly_rate' => 'decimal:2',
        'rating' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sessions()
    {
        return $this->hasMany(TherapySession::class, 'therapist_id', 'user_id');
    }
}
