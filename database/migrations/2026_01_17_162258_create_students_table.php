<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('adm_number')->unique();
            $table->string('full_name');
            $table->date('dob');
            $table->string('gender');
            $table->string('nationality');
            
            // These were missing!
            $table->string('birth_cert_number')->nullable();
            
            // Parent/Guardian Info
            $table->string('parent_name');
            $table->string('parent_relation');
            $table->string('parent_phone');
            $table->string('guardian_id_number')->nullable();
            $table->string('home_location');
            
            // Academic History
            $table->string('previous_school')->nullable();
            $table->string('kcpe_index')->nullable();
            $table->string('last_grade_completed')->nullable();
            
            // Admission Details
            $table->string('class_applied'); // e.g. "Form 1"
            $table->string('study_mode'); // Boarding/Day
            $table->string('status')->default('Active');
            $table->string('intake_term');
            
            // Who added them?
            $table->foreignId('admitted_by')->constrained('users')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};