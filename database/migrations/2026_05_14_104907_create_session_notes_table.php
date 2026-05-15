<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('session_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('therapy_sessions')->onDelete('cascade');
            $table->foreignId('therapist_id')->constrained('users')->onDelete('cascade');
            $table->text('content');
            $table->boolean('is_private')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('session_notes');
    }
};
