<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\ExamRecord;
use App\Models\SchoolClass;
use App\Models\Stream;
use App\Models\Subject;
use App\Models\Student;

class ExamController extends Controller
{
    // 1. EXAM DASHBOARD (List active exams)
    public function index()
    {
        $exams = Exam::orderBy('start_date', 'desc')->get();
        return view('academics.exams.index', compact('exams'));
    }

    // 2. CREATE NEW EXAM
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'term' => 'required',
            'year' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Exam::create($request->all());
        return back()->with('success', 'Exam Cycle Created Successfully');
    }

    // 3. MARK ENTRY INTERFACE (The Spreadsheet View)
    public function markEntry(Request $request)
    {
        $exams = Exam::all();
        $classes = SchoolClass::with('streams')->get();
        $subjects = Subject::all();
        
        $students = [];
        $selectedExam = null;
        $selectedSubject = null;
        $selectedStream = null;

        // If user has selected filters, load the students list
        if ($request->has(['exam_id', 'stream_id', 'subject_id'])) {
            $students = Student::where('stream_id', $request->stream_id)
                ->where('status', 'Active')
                ->orderBy('full_name')
                ->get();
                
            $selectedExam = Exam::find($request->exam_id);
            $selectedSubject = Subject::find($request->subject_id);
            $selectedStream = Stream::find($request->stream_id);
        }

        return view('academics.exams.mark_entry', compact('exams', 'classes', 'subjects', 'students', 'selectedExam', 'selectedSubject', 'selectedStream'));
    }

    // 4. SAVE MARKS (Bulk Save)
    public function storeMarks(Request $request)
    {
        $request->validate([
            'exam_id' => 'required',
            'subject_id' => 'required',
            'marks' => 'required|array', // Array of marks [student_id => score]
        ]);

        foreach ($request->marks as $studentId => $score) {
            if ($score !== null) {
                // Calculate Grade logic
                $grading = $this->calculateGrade($score);

                ExamRecord::updateOrCreate(
                    [
                        'exam_id' => $request->exam_id,
                        'student_id' => $studentId,
                        'subject_id' => $request->subject_id,
                    ],
                    [
                        'stream_id' => Student::find($studentId)->stream_id,
                        'marks_obtained' => $score,
                        'grade' => $grading['grade'],
                        'remarks' => $grading['remarks'],
                    ]
                );
            }
        }

        return back()->with('success', 'Marks Saved Successfully!');
    }

    // HELPER: Grading Logic (Can be moved to a DB table later for sophistication)
    private function calculateGrade($score)
    {
        if ($score >= 80) return ['grade' => 'A', 'remarks' => 'Excellent'];
        if ($score >= 75) return ['grade' => 'A-', 'remarks' => 'Very Good'];
        if ($score >= 70) return ['grade' => 'B+', 'remarks' => 'Good'];
        if ($score >= 65) return ['grade' => 'B', 'remarks' => 'Good'];
        if ($score >= 60) return ['grade' => 'B-', 'remarks' => 'Fair'];
        if ($score >= 55) return ['grade' => 'C+', 'remarks' => 'Average'];
        if ($score >= 50) return ['grade' => 'C', 'remarks' => 'Average'];
        if ($score >= 45) return ['grade' => 'C-', 'remarks' => 'Below Average'];
        if ($score >= 40) return ['grade' => 'D+', 'remarks' => 'Weak'];
        if ($score >= 35) return ['grade' => 'D', 'remarks' => 'Weak'];
        if ($score >= 30) return ['grade' => 'D-', 'remarks' => 'Poor'];
        return ['grade' => 'E', 'remarks' => 'Fail'];
    }
}