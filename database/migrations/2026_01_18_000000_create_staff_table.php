<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            
            // This is the column that was missing!
            $table->string('staff_number')->unique(); 
            $table->string('role'); 
            
            // Identity
            $table->string('full_name');
            $table->string('national_id_number')->unique();
            $table->string('passport_photo_path')->nullable();
            $table->string('gender');
            
            // Contact
            $table->string('phone_number');
            $table->string('email')->nullable();
            $table->string('residence')->nullable();
            
            // Employment
            $table->string('department')->nullable();
            $table->string('position');
            $table->string('employment_type');
            $table->date('joining_date');
            
            // Extra
            $table->string('highest_qualification')->nullable();
            $table->string('tsc_number')->nullable();
            $table->text('subjects_specialization')->nullable();
            $table->string('kra_pin')->nullable();
            $table->string('nssf_no')->nullable();
            $table->string('nhif_no')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account_no')->nullable();
            $table->string('status')->default('Active');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};