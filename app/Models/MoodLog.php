<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoodLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'score', 'emotion', 'tags', 'note', 'logged_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'logged_at' => 'datetime',
        'score' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getMoodLabelAttribute(): string
    {
        return match(true) {
            $this->score >= 9 => 'Excellent',
            $this->score >= 7 => 'Good',
            $this->score >= 5 => 'Neutral',
            $this->score >= 3 => 'Low',
            default           => 'Very Low',
        };
    }

    public function getMoodColorAttribute(): string
    {
        return match(true) {
            $this->score >= 9 => '#3D8B6E',
            $this->score >= 7 => '#2D6A6A',
            $this->score >= 5 => '#8B7FD4',
            $this->score >= 3 => '#D4956A',
            default           => '#C0504A',
        };
    }
}
