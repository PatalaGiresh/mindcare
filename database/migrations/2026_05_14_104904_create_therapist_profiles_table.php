<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('therapist_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('specialty');
            $table->text('bio')->nullable();
            $table->decimal('hourly_rate', 8, 2)->default(500.00);
            $table->integer('experience_years')->default(0);
            $table->string('qualification')->nullable();
            $table->string('languages')->nullable();
            $table->json('availability')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_available')->default(true);
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->integer('total_sessions')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('therapist_profiles');
    }
};
