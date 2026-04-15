<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Import Controllers
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AcademicController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\HostelController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RolePermissionController;

// Import Models for Dashboard Statistics
use App\Models\Student;
use App\Models\Staff;
use App\Models\SchoolClass;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// --- DASHBOARD ROUTE (FIXED) ---
Route::get('/dashboard', function () {
    // 1. Fetch real-time stats
    $totalStudents = Student::count();
    $totalStaff = Staff::count();
    $totalClasses = SchoolClass::count();

    // 2. Fetch recent students (Last 5 added)
    // This variable ($recentStudents) fixes the "Undefined variable" error
    $recentStudents = Student::latest()->take(5)->get();

    // 3. Pass ALL variables to the view
    return view('dashboard', compact('totalStudents', 'totalStaff', 'totalClasses', 'recentStudents'));
})->middleware(['auth', 'verified'])->name('dashboard');


// --- AUTHENTICATED ROUTES GROUP ---
Route::middleware('auth')->group(function () {
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==========================================
    // MODULE 1: STUDENTS & ADMISSIONS
    // ==========================================
    Route::get('/admissions', [StudentController::class, 'create'])->name('admissions.create');
    Route::post('/admissions', [StudentController::class, 'store'])->name('admissions.store');
    
    // Student List & Profile
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store'); // For the form submission
    Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');

    // ==========================================
    // MODULE 2: STAFF / HR
    // ==========================================
    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::get('/staff/onboard', [StaffController::class, 'create'])->name('staff.create');
    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::get('/staff/{staff}', [StaffController::class, 'show'])->name('staff.show');

   // ==========================================
    // MODULE 3: ACADEMICS
    // ==========================================
    Route::prefix('academics')->group(function () {
        
        // 1. Classes Management Page
        Route::get('/classes', [AcademicController::class, 'classes'])->name('academics.classes');
        
        // 2. Class CRUD (Create, Update, Delete)
        Route::post('/classes', [AcademicController::class, 'storeClass'])->name('academics.classes.store');
        Route::put('/classes/{class}', [AcademicController::class, 'updateClass'])->name('academics.classes.update');
        Route::delete('/classes/{class}', [AcademicController::class, 'destroyClass'])->name('academics.classes.destroy');
        
        // 3. Stream Management (Add, Remove)
        Route::post('/streams', [AcademicController::class, 'storeStream'])->name('academics.streams.store');
        Route::delete('/classes/{class}/streams/{stream}', [AcademicController::class, 'removeStream'])->name('academics.streams.remove');
        
        // Timetables
        Route::get('/timetables', [AcademicController::class, 'timetables'])->name('academics.timetables');
        Route::post('/timetables', [AcademicController::class, 'storeLesson'])->name('academics.timetables.store');

        // Exams & Grades
        Route::get('/exams', [ExamController::class, 'index'])->name('academics.exams.index');
        Route::post('/exams', [ExamController::class, 'store'])->name('academics.exams.store');
        Route::get('/exams/marks', [ExamController::class, 'markEntry'])->name('academics.exams.marks');
        Route::post('/exams/marks', [ExamController::class, 'storeMarks'])->name('academics.exams.marks.store');
    });

    // ==========================================
    // MODULE 4: FINANCE
    // ==========================================
    Route::prefix('finance')->group(function () {
        Route::get('/fees', [FinanceController::class, 'fees'])->name('finance.fees');
        Route::get('/expenses', [FinanceController::class, 'expenses'])->name('finance.expenses');
    });

    // ==========================================
    // MODULE 5: LOGISTICS & SYSTEM
    // ==========================================
    Route::get('/transport', [TransportController::class, 'index'])->name('transport.index');
    Route::get('/hostel', [HostelController::class, 'index'])->name('hostel.index');
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/library', [LibraryController::class, 'index'])->name('library.index');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // ==========================================
    // MODULE 6: SYSTEM SETTINGS (Super Admin Only)
    // ==========================================
    Route::group(['prefix' => 'admin'], function () {
        
        // Settings Dashboard
        Route::get('/settings', [RolePermissionController::class, 'index'])->name('admin.settings');
        
        // User & Role Assignment
        Route::post('/users/assign', [RolePermissionController::class, 'assignRole'])->name('admin.users.assign');
        Route::post('/users/create-from-staff', [RolePermissionController::class, 'createStaffAccount'])->name('admin.users.create_staff');
        
        // Role Management
        Route::post('/roles', [RolePermissionController::class, 'storeRole'])->name('admin.roles.store');
        Route::put('/roles/{role}/permissions', [RolePermissionController::class, 'updatePermissions'])->name('admin.roles.permissions');
        Route::post('/settings/branding', [RolePermissionController::class, 'updateSettings'])->name('admin.settings.branding');
    });

}); // --- END AUTH GROUP ---

require __DIR__.'/auth.php';