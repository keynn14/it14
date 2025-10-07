<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ReturneeController;
use App\Http\Controllers\TransfereeController;
use App\Http\Controllers\PrincipalController;

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/student-list', function () {
    return view('student-list');
})->middleware(['auth', 'verified'])->name('student.list');

Route::get('/courses', function () {
    return view('courses');
})->middleware(['auth', 'verified'])->name('courses');

// Enrollment Routes
Route::get('/enrollment', [EnrollmentController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])->name('enrollment');

// Returnee Enrollment Routes
Route::get('/enrollment/returnee', [ReturneeController::class, 'showEnrollmentForm'])
    ->middleware(['auth', 'verified'])->name('enrollment.returnee');

Route::post('/enrollment/search-student', [EnrollmentController::class, 'searchStudent'])
    ->middleware(['auth', 'verified'])->name('enrollment.search-student');

Route::post('/enrollment/enroll-returnee', [EnrollmentController::class, 'enrollReturnee'])
    ->middleware(['auth', 'verified'])->name('enrollment.enroll-returnee');

// Old Student Enrollment
Route::get('/enrollment/old-student', function () {
    return view('enrollment.old-student');
})->middleware(['auth', 'verified'])->name('enrollment.old-student');

// New Student Enrollment
Route::get('/enrollment/new-student', function () {
    return view('enrollment.new-student');
})->middleware(['auth', 'verified'])->name('enrollment.new-student');

// Transferee Enrollment Routes (3-step process)
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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'role:principal'])->prefix('principal')->group(function () {
    Route::get('/dashboard', [PrincipalController::class, 'dashboard'])->name('principal.dashboard');
    Route::get('/pending-students', [PrincipalController::class, 'pendingStudents'])->name('principal.pending-students');
    Route::post('/approve/{id}', [PrincipalController::class, 'approve'])->name('principal.approve');
    Route::post('/reject/{id}', [PrincipalController::class, 'reject'])->name('principal.reject');
});
require __DIR__.'/auth.php';