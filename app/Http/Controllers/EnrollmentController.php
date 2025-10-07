<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Enrollment;
use App\Models\AcademicRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{
    public function dashboard()
    {
        return view('enrollment');
    }

    public function searchStudent(Request $request)
    {
        $request->validate([
            'lrn' => 'required|string|size:12'
        ]);

        $student = Student::with(['academicRecords' => function($query) {
            $query->orderBy('school_year', 'desc')
                  ->orderBy('grade_level', 'desc');
        }])->where('lrn', $request->lrn)->first();

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found with the provided LRN.'
            ], 404);
        }

        // Calculate promotion status
        $latestRecords = $student->academicRecords->groupBy('school_year')->first();
        $promotionStatus = $this->calculatePromotionStatus($latestRecords);

        return response()->json([
            'success' => true,
            'student' => $student,
            'academic_records' => $latestRecords,
            'promotion_status' => $promotionStatus
        ]);
    }

    public function enrollReturnee(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'school_year' => 'required|string',
            'grade_level' => 'required|integer|min:7|max:12'
        ]);

        DB::transaction(function () use ($request) {
            // Check if student is already enrolled for this school year
            $existingEnrollment = Enrollment::where('student_id', $request->student_id)
                ->where('school_year', $request->school_year)
                ->first();

            if ($existingEnrollment) {
                throw new \Exception('Student is already enrolled for this school year.');
            }

            // Create enrollment
            $enrollment = Enrollment::create([
                'student_id' => $request->student_id,
                'school_year' => $request->school_year,
                'grade_level' => $request->grade_level,
                'enrollment_type' => 'returnee',
                'status' => 'approved'
            ]);

            // Update student status and type
            Student::where('id', $request->student_id)->update([
                'status' => 'active',
                'student_type' => 'returnee'
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Returnee student enrolled successfully!'
        ]);
    }

    private function calculatePromotionStatus($academicRecords)
    {
        if (!$academicRecords) {
            return [
                'status' => 'unknown',
                'message' => 'No academic records found.',
                'failed_count' => 0
            ];
        }

        $failedSubjects = $academicRecords->filter(function ($record) {
            return $record->grade < 75;
        });

        $failedCount = $failedSubjects->count();

        if ($failedCount === 0) {
            return [
                'status' => 'promoted',
                'message' => 'Student is eligible for promotion to the next grade level.',
                'failed_count' => 0
            ];
        } elseif ($failedCount <= 3) {
            return [
                'status' => 'remediation',
                'message' => "Student requires remediation in {$failedCount} subject(s) but is eligible for promotion.",
                'failed_count' => $failedCount
            ];
        } else {
            return [
                'status' => 'retained',
                'message' => "Student has failed {$failedCount} subjects and must repeat the grade level.",
                'failed_count' => $failedCount
            ];
        }
    }
}