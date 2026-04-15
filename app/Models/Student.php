<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * This list must match your database columns exactly.
     */
    protected $fillable = [
        'adm_number',
        'full_name',
        'dob',
        'gender',
        'nationality',
        'birth_cert_number',
        'parent_name',
        'parent_relation',
        'parent_phone',
        'guardian_id_number',
        'home_location',
        'previous_school',
        'kcpe_index',
        'last_grade_completed',
        'class_applied',
        'study_mode',
        'passport_photo_path', // <--- This is the crucial new field
        'status',
        'intake_term',
        'admitted_by',
        'stream_id', // Included in case you assign streams later
    ];

    /**
     * OPTIONAL: Relationships
     * If you have a Stream model, this links the student to it.
     */
    public function stream()
    {
        return $this->belongsTo(ClassStream::class, 'stream_id');
    }

    /**
     * Helper to get the full photo URL
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->passport_photo_path) {
            return asset('storage/' . $this->passport_photo_path);
        }
        // Return a default placeholder if no photo exists
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->full_name) . '&background=random';
    }
    // Link to the real Class
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}