<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// This migration is a placeholder - role is already added in the main users table migration
return new class extends Migration
{
    public function up(): void
    {
        // Role column already included in create_users_table migration
    }

    public function down(): void
    {
        //
    }
};
