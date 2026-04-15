<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $fillable = ['name']; // removed teacher_id from here

    // RELATIONSHIP: Streams
    // Now using the custom pivot model so we can fetch the stream teacher
    public function streams()
    {
        return $this->belongsToMany(ClassStream::class, 'school_class_stream', 'school_class_id', 'class_stream_id')
                    ->using(SchoolClassStream::class)
                    ->withPivot('teacher_id');
    }
}
