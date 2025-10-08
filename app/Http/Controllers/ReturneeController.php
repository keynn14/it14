<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Returnee;
use App\Models\AcademicRecord;
use Illuminate\Support\Facades\DB;

class ReturneeController extends Controller
{
    public function showEnrollmentForm()
    {
        return view('enrollment.returnee');
    }

    public function searchStudent(Request $request)
    {
        $request->validate([
            'lrn' => 'required|digits:12'
        ]);

        $student = Student::where('lrn', $request->lrn)
            ->with(['academicRecords' => function($query) {
                $query->where('school_year', '2023-2024')->orderBy('subject');
            }])
            ->first();

        if ($student) {
            // Check if student is already enrolled for current school year
            $currentEnrollment = Enrollment::where('student_id', $student->id)
                ->where('school_year', '2024-2025')
                ->first();

            if ($currentEnrollment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student is already enrolled for the current school year.'
                ]);
            }

            return response()->json([
                'success' => true,
                'student' => $student,
                'academicRecords' => $student->academicRecords
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No student found with the provided LRN.'
        ]);
    }

    public function enrollReturnee(Request $request)
    {
        $request->validate([
            'lrn' => 'required|digits:12',
            'grade_level' => 'required|integer|between:7,12',
            'section' => 'nullable|string|max:50',
            'track' => 'nullable|string|max:100',
            'strand' => 'nullable|string|max:100'
        ]);

        try {
            DB::transaction(function () use ($request) {
                $student = Student::where('lrn', $request->lrn)->first();
                
                if (!$student) {
                    throw new \Exception('Student not found.');
                }

                // Update student type
                $student->update([
                    'student_type' => Student::TYPE_RETURNEE,
                    'status' => Student::STATUS_ACTIVE
                ]);

                // Create returnee record
                $returnee = Returnee::create([
                    'student_id' => $student->id,
                    'previous_school_year' => '2023-2024',
                    'previous_grade_level' => $student->last_grade,
                    'new_grade_level' => $request->grade_level,
                    'reason_for_return' => $request->reason ?? 'Continuing education',
                    'academic_status' => []
                ]);

                // Calculate promotion status
                $promotionStatus = $returnee->calculatePromotionStatus();

                // Create enrollment record with correct status
                $enrollment = Enrollment::create([
                    'student_id' => $student->id,
                    'school_year' => '2024-2025',
                    'grade_level' => $request->grade_level,
                    'enrollment_type' => Enrollment::TYPE_RETURNEE,
                    'status' => $promotionStatus['can_proceed'] ? Enrollment::STATUS_APPROVED : Enrollment::STATUS_PENDING,
                    'section' => $request->section,
                    'track' => $request->track,
                    'strand' => $request->strand,
                    'remarks' => $promotionStatus['can_proceed'] ? 'Automatically approved' : 'Needs review - failed subjects'
                ]);

                // Update student's last grade and school year
                $student->update([
                    'last_grade' => $request->grade_level,
                    'last_school_year' => '2024-2025'
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Student enrolled successfully as returnee!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error enrolling student: ' . $e->getMessage()
            ]);
        }
    }

    public function storeAcademicRecords(Request $request)
    {
        $request->validate([
            'lrn' => 'required|digits:12',
            'grades' => 'required|array',
            'grades.*.subject' => 'required|string',
            'grades.*.grade' => 'required|numeric|min:65|max:100',
            'school_year' => 'required|string'
        ]);

        $student = Student::where('lrn', $request->lrn)->first();

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found.'
            ]);
        }

        try {
            DB::transaction(function () use ($request, $student) {
                // Delete existing records for this school year
                AcademicRecord::where('student_id', $student->id)
                    ->where('school_year', $request->school_year)
                    ->delete();

                // Create new records
                foreach ($request->grades as $gradeData) {
                    AcademicRecord::create([
                        'student_id' => $student->id,
                        'subject' => $gradeData['subject'],
                        'grade' => $gradeData['grade'],
                        'school_year' => $request->school_year,
                        'semester' => $gradeData['semester'] ?? '1st'
                    ]);
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Academic records saved successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving academic records: ' . $e->getMessage()
            ]);
        }
    }

    public function getPromotionStatus(Request $request)
    {
        $request->validate([
            'lrn' => 'required|digits:12'
        ]);

        $student = Student::where('lrn', $request->lrn)->first();

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found.'
            ]);
        }

        $records = AcademicRecord::where('student_id', $student->id)
            ->where('school_year', '2023-2024')
            ->get();

        $failedSubjects = $records->filter(function ($record) {
            return $record->grade < 75;
        });

        $status = [
            'failed_count' => $failedSubjects->count(),
            'failed_subjects' => $failedSubjects->map(function ($record) {
                return [
                    'subject' => $record->subject,
                    'grade' => $record->grade
                ];
            })->toArray(),
            'can_proceed' => $failedSubjects->count() <= 3,
            'average_grade' => round($records->avg('grade'), 2),
            'total_subjects' => $records->count()
        ];

        return response()->json([
            'success' => true,
            'promotion_status' => $status
        ]);
    }
}