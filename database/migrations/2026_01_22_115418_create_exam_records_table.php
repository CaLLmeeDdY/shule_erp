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
    Schema::create('exam_records', function (Blueprint $table) {
        $table->id();
        $table->foreignId('exam_id')->constrained()->onDelete('cascade');
        $table->foreignId('student_id')->constrained()->onDelete('cascade');
        $table->foreignId('subject_id')->constrained()->onDelete('cascade');
        $table->foreignId('stream_id')->constrained()->onDelete('cascade'); // To help filter results by class later
        
        $table->integer('marks_obtained'); // The raw score (e.g., 78)
        $table->string('grade')->nullable(); // The calculated grade (e.g., "A-")
        $table->string('remarks')->nullable(); // e.g., "Excellent"
        
        $table->timestamps();
        
        // Prevent duplicate entry for same student+exam+subject
        $table->unique(['exam_id', 'student_id', 'subject_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_records');
    }
};
