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
        Schema::create('streams', function (Blueprint $table) {
            $table->id();
            
            // Link to the Class (e.g., Form 1)
            $table->foreignId('school_class_id')->constrained('school_classes')->onDelete('cascade');
            
            // Stream Name (e.g., "Blue", "East")
            $table->string('name');
            
            // Link to the Teacher
            $table->foreignId('class_teacher_id')->nullable()->constrained('staff')->onDelete('set null');
            
            $table->integer('capacity')->default(45);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('streams');
    }
};