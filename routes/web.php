<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ReturneeController;
use App\Http\Controllers\TransfereeController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Principal\ReturneeController as PrincipalReturneeController;
use App\Http\Controllers\Principal\TransfereeController as PrincipalTransfereeController;

// MAIN DASHBOARD
Route::get('/', function () {
    if (auth()->check() && auth()->user()->isPrincipal()) {
        return redirect()->route('principal.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->isPrincipal()) {
        return redirect()->route('principal.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified']);

// STATIC PAGES
Route::get('/student-list', fn() => view('student-list'))->middleware(['auth', 'verified'])->name('student.list');
Route::get('/courses', fn() => view('courses'))->middleware(['auth', 'verified'])->name('courses');

// ENROLLMENT
Route::get('/enrollment', [EnrollmentController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])->name('enrollment');

// RETURNEE ENROLLMENT (Regular users)
Route::get('/enrollment/returnee', [ReturneeController::class, 'showEnrollmentForm'])
    ->middleware(['auth', 'verified'])->name('enrollment.returnee');
Route::post('/enrollment/returnee/search', [ReturneeController::class, 'searchStudent'])
    ->middleware(['auth', 'verified'])->name('returnee.search');
Route::post('/enrollment/returnee/enroll', [ReturneeController::class, 'enrollReturnee'])
    ->middleware(['auth', 'verified'])->name('returnee.enroll');
Route::post('/enrollment/returnee/store-records', [ReturneeController::class, 'storeAcademicRecords'])
    ->middleware(['auth', 'verified'])->name('returnee.store.records');
Route::post('/enrollment/returnee/promotion-status', [ReturneeController::class, 'getPromotionStatus'])
    ->middleware(['auth', 'verified'])->name('returnee.promotion-status');

// BACKWARD COMPATIBILITY
Route::post('/enrollment/search-student', [EnrollmentController::class, 'searchStudent'])
    ->middleware(['auth', 'verified'])->name('enrollment.search-student');
Route::post('/enrollment/enroll-returnee', [EnrollmentController::class, 'enrollReturnee'])
    ->middleware(['auth', 'verified'])->name('enrollment.enroll-returnee');

// OLD / NEW STUDENTS
Route::get('/enrollment/old-student', fn() => view('enrollment.old-student'))
    ->middleware(['auth', 'verified'])->name('enrollment.old-student');
Route::get('/enrollment/new-student', fn() => view('enrollment.new-student'))
    ->middleware(['auth', 'verified'])->name('enrollment.new-student');

// TRANSFEREE ENROLLMENT (3-step) - Regular users
Route::get('/enrollment/transferee', [TransfereeController::class, 'showInfoForm'])
    ->middleware(['auth', 'verified'])->name('transferee.info');
Route::post('/enrollment/transferee/info', [TransfereeController::class, 'processInfo'])
    ->middleware(['auth', 'verified'])->name('transferee.info.process');
Route::get('/enrollment/transferee/academic', [TransfereeController::class, 'showAcademicForm'])
    ->middleware(['auth', 'verified'])->name('transferee.academic');
Route::post('/enrollment/transferee/academic', [TransfereeController::class, 'processAcademic'])
    ->middleware(['auth', 'verified'])->name('transferee.academic.process');
Route::get('/enrollment/transferee/documents', [TransfereeController::class, 'showDocumentsForm'])
    ->middleware(['auth', 'verified'])->name('transferee.documents');
Route::post('/enrollment/transferee/submit', [TransfereeController::class, 'submitEnrollment'])
    ->middleware(['auth', 'verified'])->name('transferee.submit');

// STUDENT MANAGEMENT
Route::middleware(['auth', 'verified'])->prefix('students')->group(function () {
    Route::get('/', [StudentController::class, 'index'])->name('students.index');
    Route::get('/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/', [StudentController::class, 'store'])->name('students.store');
    Route::get('/{student}', [StudentController::class, 'show'])->name('students.show');
    Route::get('/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/{student}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/{student}', [StudentController::class, 'destroy'])->name('students.destroy');

    // Academic Records
    Route::get('/{student}/academic-records', [StudentController::class, 'academicRecords'])->name('students.academic-records');
    Route::post('/{student}/academic-records', [StudentController::class, 'storeAcademicRecord'])->name('students.store-academic-record');
    Route::delete('/academic-records/{record}', [StudentController::class, 'destroyAcademicRecord'])->name('students.destroy-academic-record');

    // Enrollment History
    Route::get('/{student}/enrollments', [StudentController::class, 'enrollmentHistory'])->name('students.enrollments');
});

// ✅ UNIQUE ROUTES FROM FIRST FILE (added here)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/student/{id}', [StudentController::class, 'getStudent']);
    Route::post('/students/update', [StudentController::class, 'updateStudent'])->name('students.update.sanctum');
});
Route::post('/students/list', [EnrollmentController::class, 'listStudents'])->name('students.list');
Route::delete('/students/{id}', [EnrollmentController::class, 'destroy'])->name('students.destroy.legacy');
Route::post('/students/update', [EnrollmentController::class, 'updateStudent'])->name('students.update.legacy');

// ENROLLMENT MANAGEMENT (Principal only)
Route::middleware(['auth', 'verified', 'role:principal'])->prefix('enrollments')->group(function () {
    Route::get('/', [EnrollmentController::class, 'index'])->name('enrollments.index');
    Route::get('/pending', [EnrollmentController::class, 'pending'])->name('enrollments.pending');
    Route::get('/active', [EnrollmentController::class, 'active'])->name('enrollments.active');
    Route::post('/{enrollment}/approve', [EnrollmentController::class, 'approve'])->name('enrollments.approve');
    Route::post('/{enrollment}/reject', [EnrollmentController::class, 'reject'])->name('enrollments.reject');
    Route::post('/{enrollment}/cancel', [EnrollmentController::class, 'cancel'])->name('enrollments.cancel');
});

// TRANSFEREE MANAGEMENT (Principal only)
Route::middleware(['auth', 'verified', 'role:principal'])->prefix('transferees')->group(function () {
    Route::get('/', [PrincipalTransfereeController::class, 'index'])->name('transferees.index');
    Route::get('/pending', [PrincipalTransfereeController::class, 'pending'])->name('transferees.pending');
    Route::get('/{transferee}', [PrincipalTransfereeController::class, 'show'])->name('transferees.show');
    Route::post('/{transferee}/approve', [PrincipalTransfereeController::class, 'approve'])->name('transferees.approve');
    Route::post('/{transferee}/reject', [PrincipalTransfereeController::class, 'reject'])->name('transferees.reject');
});

// RETURNEE MANAGEMENT (Principal only)
Route::middleware(['auth', 'verified', 'role:principal'])->prefix('returnees')->group(function () {
    Route::get('/', [PrincipalReturneeController::class, 'index'])->name('returnees.index');
    Route::get('/pending', [PrincipalReturneeController::class, 'pending'])->name('returnees.pending');
    Route::get('/{returnee}', [PrincipalReturneeController::class, 'show'])->name('returnees.show');
    Route::post('/{returnee}/approve', [PrincipalReturneeController::class, 'approve'])->name('returnees.approve');
    Route::post('/{returnee}/reject', [PrincipalReturneeController::class, 'reject'])->name('returnees.reject');
});

// PRINCIPAL ROUTES
Route::middleware(['auth', 'verified', 'role:principal'])->prefix('principal')->group(function () {
    Route::get('/dashboard', [PrincipalController::class, 'dashboard'])->name('principal.dashboard');
    Route::get('/pending-students', [PrincipalController::class, 'pendingStudents'])->name('principal.pending-students');
    Route::get('/pending-transferees', [PrincipalController::class, 'pendingTransferees'])->name('principal.pending-transferees');
    Route::get('/pending-returnees', [PrincipalController::class, 'pendingReturnees'])->name('principal.pending-returnees');
    Route::post('/approve/{id}', [PrincipalController::class, 'approve'])->name('principal.approve');
    Route::post('/reject/{id}', [PrincipalController::class, 'reject'])->name('principal.reject');
    Route::post('/approve-transferee/{id}', [PrincipalController::class, 'approveTransferee'])->name('principal.approve-transferee');
    Route::post('/reject-transferee/{id}', [PrincipalController::class, 'rejectTransferee'])->name('principal.reject-transferee');
    Route::post('/approve-returnee/{id}', [PrincipalController::class, 'approveReturnee'])->name('principal.approve-returnee');

    // Reports
    Route::get('/reports/enrollment', [PrincipalController::class, 'enrollmentReports'])->name('principal.enrollment-reports');
    Route::get('/reports/students', [PrincipalController::class, 'studentReports'])->name('principal.student-reports');
});

// PROFILE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// REPORTS
Route::middleware(['auth', 'verified'])->prefix('reports')->group(function () {
    Route::get('/enrollment', [EnrollmentController::class, 'enrollmentReport'])->name('reports.enrollment');
    Route::get('/students', [StudentController::class, 'studentReport'])->name('reports.students');
    Route::get('/transferees', [TransfereeController::class, 'transfereeReport'])->name('reports.transferees');
    Route::get('/returnees', [ReturneeController::class, 'returneeReport'])->name('reports.returnees');
});

// TEST PRINCIPAL ACCESS
Route::get('/test-principal', function () {
    if (auth()->check() && auth()->user()->isPrincipal()) {
        return "Welcome Principal! You have access to principal features.";
    }
    return "You are a regular user. Access to principal features is restricted.";
})->middleware(['auth', 'verified'])->name('test.principal');

require __DIR__ . '/auth.php';
