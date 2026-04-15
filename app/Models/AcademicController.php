<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\ClassStream;
use App\Models\Staff;

class AcademicController extends Controller
{
    /**
     * Show the Classes & Streams Management Page
     */
    public function classes()
    {
        // Fetch all classes with their linked streams and teachers
        $classes = SchoolClass::with(['streams', 'teacher'])->get();
        
        // Fetch all staff for the "Assign Teacher" dropdown
        $teachers = Staff::all(); 

        return view('academics.classes.index', compact('classes', 'teachers'));
    }

    /**
     * Store a New Class (e.g., Form 1)
     */
    public function storeClass(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:school_classes,name',
        ]);

        SchoolClass::create([
            'name' => $request->name
        ]);

        return back()->with('success', 'Class Created Successfully');
    }

    /**
     * Store a New Stream (e.g., East) and Link it to a Class
     */
    public function storeStream(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'stream_name' => 'required|string',
            'teacher_id' => 'nullable|exists:staff,id',
            'capacity' => 'nullable|integer',
        ]);

        // 1. Find or Create the Stream Definition (e.g., "East")
        // This makes sure we don't have duplicate "East" streams in the database
        $stream = ClassStream::firstOrCreate(['name' => $request->stream_name]);

        // 2. Link the Stream to the Class (Pivot Table)
        $class = SchoolClass::find($request->class_id);

        // Check if this class already has this stream to prevent duplicates
        if (!$class->streams()->where('class_stream_id', $stream->id)->exists()) {
            $class->streams()->attach($stream->id);
        }

        // 3. Assign the Class Teacher (if selected)
        if ($request->teacher_id) {
            $class->teacher_id = $request->teacher_id;
            $class->save();
        }

        return back()->with('success', 'Stream Added & Linked Successfully');
    }
}