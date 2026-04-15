<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\ClassStream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        // Load student with stream and class.
        // Note: We can't eagerly load 'teacher' here easily because it depends on the stream pivot.
        // We will handle the teacher display logic in the View or a Helper.
        $students = Student::with(['stream', 'schoolClass'])->latest()->paginate(10);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        $streams = ClassStream::all();
        
        // FIX: Removed 'with(\'teacher\')' because SchoolClass no longer has a direct teacher.
        // Teachers are now inside the streams!
        $classes = SchoolClass::all(); 

        return view('admissions.create', compact('streams', 'classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'adm_number' => 'required|unique:students,adm_number',
            'full_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|string',
            'nationality' => 'required|string',
            'birth_cert_number' => 'nullable|string',
            'parent_name' => 'required|string',
            'parent_relation' => 'required|string',
            'parent_phone' => 'required|string',
            'guardian_id_number' => 'nullable|string',
            'home_location' => 'required|string',
            'previous_school' => 'nullable|string',
            'kcpe_index' => 'nullable|string',
            'last_grade_completed' => 'nullable|string',
            'class_id' => 'required|exists:school_classes,id',
            'stream_id' => 'nullable|exists:class_streams,id',
            'study_mode' => 'required|string',
            'intake_term' => 'required|string',
            'passport_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('passport_photo')) {
            $path = $request->file('passport_photo')->store('student_photos', 'public');
            $validated['passport_photo_path'] = $path;
        }

        $selectedClass = SchoolClass::find($request->class_id);
        $validated['class_applied'] = $selectedClass->name; 
        
        $validated['admitted_by'] = Auth::id();
        $validated['status'] = 'Active';

        Student::create($validated);

        return redirect()->route('students.index')->with('success', 'Student admitted successfully!');
    }

    public function show(Student $student)
    {
        $student->load(['stream', 'schoolClass']);
        return view('students.show', compact('student'));
    }
}