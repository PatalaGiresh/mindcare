<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TherapistProfile;
use App\Models\Resource;
use App\Models\MoodLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            TherapistSeeder::class,
            PatientSeeder::class,
            ResourceSeeder::class,
        ]);
    }
}
