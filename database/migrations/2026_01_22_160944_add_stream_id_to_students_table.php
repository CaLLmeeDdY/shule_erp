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
        Schema::table('students', function (Blueprint $table) {
            // Add the stream_id column after 'class_applied'
            // It links to the 'streams' table
            $table->foreignId('stream_id')
                  ->nullable()
                  ->after('class_applied')
                  ->constrained('streams')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Drop the link first, then the column
            $table->dropForeign(['stream_id']);
            $table->dropColumn('stream_id');
        });
    }
};