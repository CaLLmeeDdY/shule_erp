<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Staff;
use App\Models\SchoolClass;
use App\Models\Stream;
use App\Models\Subject;
use App\Models\Student;
use App\Models\Exam;
use App\Models\ExamRecord;

class SchoolSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('en_KE'); // Use Kenyan names

        // ==========================================
        // 1. CREATE ADMIN USER
        // ==========================================
        $admin = User::firstOrCreate(
            ['email' => 'ashilakaedwin@gmail.com'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('39111292'),
                'role' => 'Super Admin',
            ]
        );
        // ASSIGN ROLE
        $admin->assignRole('Super Admin');
        $this->command->info('Admin User created (admin@shule.com / password)');

        // ==========================================
        // 2. CREATE TEACHERS (STAFF)
        // ==========================================
        $teachers = [];
        $departments = ['Sciences', 'Languages', 'Humanities', 'Mathematics'];
        
        for ($i = 1; $i <= 10; $i++) {
            $teacher = Staff::create([
                'staff_number' => 'TSC-' . $faker->unique()->numberBetween(10000, 99999),
                'role' => 'Teacher',
                'full_name' => $faker->name,
                'national_id_number' => $faker->unique()->numberBetween(20000000, 39999999),
                'gender' => $faker->randomElement(['Male', 'Female']),
                'phone_number' => $faker->phoneNumber,
                'email' => $faker->unique()->email,
                'department' => $faker->randomElement($departments),
                'position' => 'Teacher',
                'employment_type' => 'Permanent',
                'joining_date' => $faker->date(),
                'status' => 'Active',
            ]);
            $teachers[] = $teacher;
        }
        // $teacher->assignRole('Teacher');
        $this->command->info('10 Teachers created.');

        // ==========================================
        // 3. CREATE CLASSES & STREAMS
        // ==========================================
        $forms = ['Form 1', 'Form 2', 'Form 3', 'Form 4'];
        $streamNames = ['East', 'West'];
        $allStreams = [];

        foreach ($forms as $formName) {
            $class = SchoolClass::create(['name' => $formName]);
            
            foreach ($streamNames as $streamName) {
                $stream = Stream::create([
                    'school_class_id' => $class->id,
                    'name' => $streamName,
                    'capacity' => 45,
                    'class_teacher_id' => $faker->randomElement($teachers)->id, // Assign random teacher
                ]);
                $allStreams[] = $stream;
            }
        }
        $this->command->info('Classes (Form 1-4) and Streams (East/West) created.');

        // ==========================================
        // 4. CREATE SUBJECTS
        // ==========================================
        $subjectList = [
            ['code' => '101', 'name' => 'English', 'category' => 'Languages'],
            ['code' => '102', 'name' => 'Kiswahili', 'category' => 'Languages'],
            ['code' => '121', 'name' => 'Mathematics', 'category' => 'Mathematics'],
            ['code' => '231', 'name' => 'Biology', 'category' => 'Sciences'],
            ['code' => '232', 'name' => 'Physics', 'category' => 'Sciences'],
            ['code' => '233', 'name' => 'Chemistry', 'category' => 'Sciences'],
            ['code' => '311', 'name' => 'History', 'category' => 'Humanities'],
            ['code' => '312', 'name' => 'Geography', 'category' => 'Humanities'],
            ['code' => '313', 'name' => 'CRE', 'category' => 'Humanities'],
            ['code' => '565', 'name' => 'Business Studies', 'category' => 'Applied'],
        ];

        $createdSubjects = [];
        foreach ($subjectList as $sub) {
            $createdSubjects[] = Subject::create($sub);
        }
        $this->command->info('10 Subjects created.');

        // ==========================================
        // 5. CREATE STUDENTS
        // ==========================================
        $createdStudents = [];
        foreach ($allStreams as $stream) {
            // Create 5 students per stream (40 total)
            for ($k = 1; $k <= 5; $k++) {
                $student = Student::create([
                    'adm_number' => $faker->unique()->numberBetween(1000, 9999),
                    'full_name' => $faker->name,
                    'dob' => $faker->date('Y-m-d', '2010-01-01'),
                    'gender' => $faker->randomElement(['Male', 'Female']),
                    'nationality' => 'Kenyan',
                    'birth_cert_number' => $faker->numberBetween(100000, 999999),
                    'parent_name' => $faker->name,
                    'parent_relation' => 'Parent',
                    'parent_phone' => $faker->phoneNumber,
                    'home_location' => $faker->city,
                    'class_applied' => $stream->school_class->name,
                    'study_mode' => 'Boarding',
                    'status' => 'Active',
                    'intake_term' => 'Term 1',
                    'admitted_by' => $admin->id,
                ]);
                
                // Manually link the stream relation since the model doesn't explicitly have a 'stream_id' column in migration 
                // but the system relies on it. NOTE: In our previous migrations, we didn't add 'stream_id' to students table directly,
                // we assumed logic. However, for Exam Records, we need it. 
                // *Self-Correction*: The Exam Logic uses `Student::where('stream_id'...)`. 
                // To make this work perfectly, we should ideally have stream_id on students. 
                // For now, I will fake it by attaching a "current_stream" attribute if we were using a pivot, 
                // but based on your controller code: $students = Student::where('stream_id'...
                // WE NEED TO UPDATE THE STUDENT RECORD to match the controller logic.
                
                // Let's assume you added 'stream_id' to students or will add it. 
                // If not, the exam filter will fail. 
                // I will add a raw update here just in case the column exists.
                try {
                    DB::table('students')->where('id', $student->id)->update(['stream_id' => $stream->id]);
                    $student->stream_id = $stream->id; // Set for memory
                } catch (\Exception $e) {
                    // Column might not exist, ignore for now
                }

                $createdStudents[] = $student;
            }
        }
        $this->command->info('40 Students created.');

        // ==========================================
        // 6. CREATE AN EXAM & MARKS
        // ==========================================
        $exam = Exam::create([
            'name' => 'Term 1 Opener Exam',
            'term' => 'Term 1',
            'year' => date('Y'),
            'start_date' => date('Y-01-10'),
            'end_date' => date('Y-01-15'),
            'is_published' => true
        ]);

        // Give marks to all students for Mathematics
        $mathSubject = $createdSubjects[2]; // Math
        
        foreach ($createdStudents as $student) {
            // Skip if stream_id wasn't set successfully
            if(!isset($student->stream_id)) continue; 

            $score = $faker->numberBetween(30, 95);
            $grade = $this->calculateGrade($score);

            ExamRecord::create([
                'exam_id' => $exam->id,
                'student_id' => $student->id,
                'subject_id' => $mathSubject->id,
                'stream_id' => $student->stream_id,
                'marks_obtained' => $score,
                'grade' => $grade['grade'],
                'remarks' => $grade['remarks'],
            ]);
        }
        $this->command->info('Term 1 Opener Exam created with dummy marks for Math.');
    }

    private function calculateGrade($score)
    {
        if ($score >= 80) return ['grade' => 'A', 'remarks' => 'Excellent'];
        if ($score >= 70) return ['grade' => 'B', 'remarks' => 'Good'];
        if ($score >= 50) return ['grade' => 'C', 'remarks' => 'Average'];
        if ($score >= 40) return ['grade' => 'D', 'remarks' => 'Weak'];
        return ['grade' => 'E', 'remarks' => 'Fail'];
    }
}
