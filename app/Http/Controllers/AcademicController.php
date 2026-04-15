<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\ClassStream;
use App\Models\Staff;
use App\Models\Period;
use App\Models\Subject;
use App\Models\TimetableEntry;

class AcademicController extends Controller
{
    /**
     * Show the Classes & Streams Management Page
     */
    public function classes()
    {
        $classes = SchoolClass::with('streams')->get();
        $teachers = Staff::all(); 

        return view('academics.classes.index', compact('classes', 'teachers'));
    }

    /**
     * Store a New Class Level
     */
    public function storeClass(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:school_classes,name',
        ]);

        SchoolClass::create(['name' => $request->name]);

        return back()->with('success', 'Class Level Created Successfully');
    }

    /**
     * Update an Existing Class
     */
    public function updateClass(Request $request, SchoolClass $class)
    {
        $request->validate([
            'name' => 'required|string|unique:school_classes,name,' . $class->id,
        ]);

        $class->update(['name' => $request->name]);

        return back()->with('success', 'Class Updated Successfully');
    }

    /**
     * Delete a Class
     */
    public function destroyClass(SchoolClass $class)
    {
        $class->delete();
        return back()->with('success', 'Class Deleted Successfully');
    }

    /**
     * Store a New Stream & Link it (WITH TEACHER)
     */
    public function storeStream(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'stream_name' => 'required|string',
            'teacher_id' => 'nullable|exists:staff,id',
        ]);

        $stream = ClassStream::firstOrCreate(['name' => $request->stream_name]);
        $class = SchoolClass::find($request->class_id);

        if (!$class->streams()->where('class_stream_id', $stream->id)->exists()) {
            $class->streams()->attach($stream->id, [
                'teacher_id' => $request->teacher_id
            ]);
        }

        return back()->with('success', 'Stream & Class Teacher Added Successfully');
    }

    /**
     * Remove a Stream from a Class
     */
    public function removeStream(SchoolClass $class, ClassStream $stream)
    {
        $class->streams()->detach($stream->id);
        return back()->with('success', 'Stream Removed from Class');
    }

    /**
     * Show the Timetables Page
     * This passes all necessary data to the view.
     */
    public function timetables()
    {
        // FIX: Fetch the 'Allocated Streams' (Pivot) instead of generic Stream Names.
        // This ensures we get specific pairs like "Form 1 - East" and "Form 2 - East"
        $streams = \App\Models\SchoolClassStream::with(['schoolClass', 'classStream', 'teacher'])->get();

        $periods = \App\Models\Period::orderBy('start_time')->get();
        $subjects = \App\Models\Subject::all();
        $teachers = Staff::all();

        return view('academics.timetables', compact('streams', 'periods', 'subjects', 'teachers'));
    }

    /**
     * Store a Lesson (Timetable Entry)
     */
    public function storeLesson(Request $request)
    {
        $request->validate([
            'stream_id'   => 'required|exists:class_streams,id',
            'day_of_week' => 'required|string',
            'period_id'   => 'required|exists:periods,id',
            'subject_id'  => 'required|exists:subjects,id',
            'teacher_id'  => 'required|exists:staff,id',
        ]);

        // Optional: Check for conflicts (e.g. Teacher already booked at this time)
        $teacherConflict = TimetableEntry::where('teacher_id', $request->teacher_id)
            ->where('day_of_week', $request->day_of_week)
            ->where('period_id', $request->period_id)
            ->exists();

        if ($teacherConflict) {
            return back()->with('error', 'Conflict! This teacher is already teaching another class at this time.');
        }

        // Save the lesson
        TimetableEntry::updateOrCreate(
            [
                'stream_id'   => $request->stream_id,
                'day_of_week' => $request->day_of_week,
                'period_id'   => $request->period_id,
            ],
            [
                'subject_id' => $request->subject_id,
                'teacher_id' => $request->teacher_id,
            ]
        );

        return back()->with('success', 'Lesson assigned successfully!');
    }
}
