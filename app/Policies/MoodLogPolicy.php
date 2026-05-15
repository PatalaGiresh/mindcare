<?php

namespace App\Policies;

use App\Models\MoodLog;
use App\Models\User;

class MoodLogPolicy
{
    public function view(User $user, MoodLog $moodLog): bool
    {
        return $user->id === $moodLog->user_id;
    }

    public function update(User $user, MoodLog $moodLog): bool
    {
        return $user->id === $moodLog->user_id;
    }

    public function delete(User $user, MoodLog $moodLog): bool
    {
        return $user->id === $moodLog->user_id;
    }
}
