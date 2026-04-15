<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimetableEntry extends Model
{
    protected $guarded = [];

    public function stream() { return $this->belongsTo(Stream::class); }
    public function subject() { return $this->belongsTo(Subject::class); }
    public function teacher() { return $this->belongsTo(Staff::class, 'teacher_id'); }
    public function period() { return $this->belongsTo(Period::class); }
}