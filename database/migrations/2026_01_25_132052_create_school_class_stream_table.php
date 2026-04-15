<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_class_stream', function (Blueprint $table) {
            $table->id();
            // Link to School Class (Form 1)
            $table->foreignId('school_class_id')->constrained('school_classes')->onDelete('cascade');
            // Link to Stream (East)
            $table->foreignId('class_stream_id')->constrained('class_streams')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_class_stream');
    }
};