<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Staff extends Model
{
    use HasFactory, Notifiable;

    /**
     * We make 'guarded' empty so we don't worry about fillable arrays
     * blocking us while we debug.
     */
    protected $guarded = []; 

    /**
     * UNIVERSAL NAME ACCESSOR
     * This fixes the "Invisible Name" issue by trying every possible column.
     */
    public function getNameAttribute($value)
    {
        // 1. If the 'name' column exists and isn't empty, use it.
        if (!empty($this->attributes['name'])) {
            return $this->attributes['name'];
        }

        // 2. Try 'full_name'
        if (!empty($this->attributes['full_name'])) {
            return $this->attributes['full_name'];
        }

        // 3. Try combining 'first_name' + 'last_name'
        $first = $this->attributes['first_name'] ?? '';
        $last  = $this->attributes['last_name'] ?? '';
        if (!empty($first) || !empty($last)) {
            return trim($first . ' ' . $last);
        }

        // 4. Try 'username'
        if (!empty($this->attributes['username'])) {
            return $this->attributes['username'];
        }

        // 5. Fallback if completely empty
        return 'Unknown Staff';
    }

    // Relationships
    public function classes()
    {
        return $this->hasMany(SchoolClass::class, 'teacher_id');
    }
}