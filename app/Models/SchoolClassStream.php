<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SchoolClassStream extends Pivot
{
    protected $table = 'school_class_stream';
    
    // Ensure we can access the ID of this link (e.g. for the timetable form)
    public $incrementing = true;

    // 1. Link to the Class (e.g. Form 1)
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }

    // 2. Link to the Stream Definition (e.g. East)
    public function classStream()
    {
        return $this->belongsTo(ClassStream::class, 'class_stream_id');
    }

    // 3. Link to the Teacher
    public function teacher()
    {
        return $this->belongsTo(Staff::class, 'teacher_id');
    }

    // 4. MAGIC ACCESSOR: This allows {{ $stream->name }} to work in your view
    public function getNameAttribute()
    {
        return $this->classStream->name ?? 'Unknown Stream';
    }
}