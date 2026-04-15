<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassStream extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // Optional: Link to students if needed later
    public function students()
    {
        return $this->hasMany(Student::class, 'stream_id');
    }
}