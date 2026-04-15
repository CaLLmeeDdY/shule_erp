<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    protected $fillable = ['school_class_id', 'name', 'class_teacher_id', 'capacity'];

    public function school_class()
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function class_teacher()
    {
        return $this->belongsTo(Staff::class, 'class_teacher_id');
    }
    
    // We will link students here later
    public function students()
    {
        return $this->hasMany(Student::class, 'stream_id');
    }
}