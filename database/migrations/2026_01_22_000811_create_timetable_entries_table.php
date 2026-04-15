<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('timetable_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stream_id')->constrained('streams')->onDelete('cascade'); // Form 1 East
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade'); // Math
            $table->foreignId('teacher_id')->constrained('staff')->onDelete('cascade'); // Mr. Kamau
            $table->foreignId('period_id')->constrained('periods')->onDelete('cascade'); // Lesson 1
            
            $table->string('day_of_week'); // Monday, Tuesday...
            $table->string('room_number')->nullable(); // Optional: Lab 1
            
            // Prevent duplicate entries for the same slot
            // 1. A class cannot have two lessons at the same time
            $table->unique(['stream_id', 'period_id', 'day_of_week'], 'unique_stream_slot'); 
            
            // 2. A teacher cannot be in two places at once
            $table->unique(['teacher_id', 'period_id', 'day_of_week'], 'unique_teacher_slot'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timetable_entries');
    }
};