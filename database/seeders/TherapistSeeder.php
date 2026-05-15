<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TherapistProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TherapistSeeder extends Seeder
{
    public function run(): void
    {
        $therapists = [
            ['name' => 'Dr. Priya Sharma',    'specialty' => 'Anxiety & Stress',        'rate' => 800,  'exp' => 8,  'rating' => 4.9, 'qual' => 'PhD Psychology, AIIMS Delhi'],
            ['name' => 'Dr. Arjun Mehta',     'specialty' => 'Depression',              'rate' => 750,  'exp' => 6,  'rating' => 4.7, 'qual' => 'MD Psychiatry, NIMHANS'],
            ['name' => 'Dr. Kavya Nair',      'specialty' => 'Trauma & PTSD',           'rate' => 900,  'exp' => 10, 'rating' => 4.8, 'qual' => 'PhD Clinical Psychology'],
            ['name' => 'Dr. Rohan Gupta',     'specialty' => 'Relationships',           'rate' => 700,  'exp' => 5,  'rating' => 4.6, 'qual' => 'MSc Counselling Psychology'],
            ['name' => 'Dr. Ananya Reddy',    'specialty' => 'Mindfulness & Wellness',  'rate' => 650,  'exp' => 7,  'rating' => 4.8, 'qual' => 'MA Psychology, Certified MBSR'],
            ['name' => 'Dr. Vikram Patel',    'specialty' => 'Child & Adolescent',      'rate' => 850,  'exp' => 12, 'rating' => 4.9, 'qual' => 'MD Child Psychiatry'],
            ['name' => 'Dr. Meera Iyer',      'specialty' => 'Addiction Recovery',      'rate' => 720,  'exp' => 9,  'rating' => 4.7, 'qual' => 'PhD Substance Abuse Counselling'],
            ['name' => 'Dr. Siddharth Kumar', 'specialty' => 'Work & Career Stress',    'rate' => 680,  'exp' => 4,  'rating' => 4.5, 'qual' => 'MSc Organizational Psychology'],
        ];

        $bios = [
            'I believe every individual has the inner strength to heal. My approach combines evidence-based therapy with compassionate listening.',
            'Specializing in helping individuals overcome life\'s challenges with a warm, non-judgmental approach and proven therapeutic methods.',
            'With over a decade of experience, I guide clients through healing with empathy, science-backed techniques, and cultural sensitivity.',
            'My practice focuses on building resilience and healthy relationship patterns through structured therapeutic frameworks.',
            'Mindfulness is at the core of my practice. I help clients develop awareness, acceptance, and lasting inner peace.',
            'Working with young minds requires patience, creativity, and deep understanding. I create a safe space for growth.',
            'Recovery is a journey, not a destination. I walk alongside my clients with compassion and evidence-based support.',
            'Modern work environments create unique pressures. I help professionals achieve balance, clarity, and purpose.',
        ];

        foreach ($therapists as $index => $data) {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => strtolower(str_replace([' ', '.'], ['', ''], $data['name'])) . '@mindcare.com',
                'password' => Hash::make('password'),
                'role'     => 'therapist',
                'gender'   => $index % 2 === 0 ? 'female' : 'male',
            ]);

            TherapistProfile::create([
                'user_id'          => $user->id,
                'specialty'        => $data['specialty'],
                'bio'              => $bios[$index],
                'hourly_rate'      => $data['rate'],
                'experience_years' => $data['exp'],
                'qualification'    => $data['qual'],
                'languages'        => 'English, Hindi',
                'is_verified'      => true,
                'is_available'     => true,
                'rating'           => $data['rating'],
                'total_sessions'   => rand(50, 300),
            ]);
        }
    }
}
