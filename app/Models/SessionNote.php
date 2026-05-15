<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionNote extends Model
{
    use HasFactory;

    protected $fillable = ['session_id', 'therapist_id', 'content', 'is_private'];

    protected $casts = ['is_private' => 'boolean'];

    public function session()
    {
        return $this->belongsTo(TherapySession::class, 'session_id');
    }

    public function therapist()
    {
        return $this->belongsTo(User::class, 'therapist_id');
    }
}
