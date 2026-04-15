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
    Schema::create('exams', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // e.g., "Term 1 Opening Exam 2026"
        $table->string('term'); // Term 1, Term 2...
        $table->year('year');
        $table->date('start_date');
        $table->date('end_date');
        $table->boolean('is_published')->default(false); // If true, students/parents can see results
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
    
};
