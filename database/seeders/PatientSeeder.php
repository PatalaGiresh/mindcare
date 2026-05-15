<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MoodLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $patients = [
            ['name' => 'Rahul Verma',   'email' => 'rahul@example.com'],
            ['name' => 'Sneha Joshi',   'email' => 'sneha@example.com'],
            ['name' => 'Amit Singh',    'email' => 'amit@example.com'],
        ];

        $emotions = ['Happy', 'Calm', 'Anxious', 'Sad', 'Stressed', 'Hopeful', 'Tired', 'Peaceful'];

        foreach ($patients as $data) {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make('password'),
                'role'     => 'patient',
            ]);

            // Seed 14 days of mood logs
            for ($i = 13; $i >= 0; $i--) {
                MoodLog::create([
                    'user_id'   => $user->id,
                    'score'     => rand(3, 9),
                    'emotion'   => $emotions[array_rand($emotions)],
                    'tags'      => [['Work stress', 'Sleep issues', 'Family'][array_rand(['Work stress', 'Sleep issues', 'Family'])]],
                    'note'      => 'Feeling ' . strtolower($emotions[array_rand($emotions)]) . ' today.',
                    'logged_at' => now()->subDays($i),
                ]);
            }
        }
    }
}
