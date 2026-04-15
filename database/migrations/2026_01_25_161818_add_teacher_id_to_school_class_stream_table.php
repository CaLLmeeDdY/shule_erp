<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('school_class_stream', function (Blueprint $table) {
            // This allows us to assign a teacher specifically to "Form 1 East"
            $table->foreignId('teacher_id')->nullable()->constrained('staff')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('school_class_stream', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropColumn('teacher_id');
        });
    }
};