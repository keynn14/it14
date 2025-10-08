<?php

namespace App\Http\Controllers\Principal;

use App\Http\Controllers\Controller;
use App\Models\Returnee;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\AcademicRecord;
use Illuminate\Http\Request;

class ReturneeController extends Controller
{
    // Show all returnees
    public function index()
    {
        $returnees = Returnee::with('student')->latest()->get();
        return view('principal.returnees.index', compact('returnees'));
    }

    // Show pending returnees
    public function pending()
    {
        $returnees = Returnee::with('student')
            ->where('status', Returnee::STATUS_PENDING)
            ->latest()
            ->get();

        return view('principal.pending.Returnee', compact('returnees'));
    }

    // Show details of one returnee
    public function show(Returnee $returnee)
    {
        $returnee->load('student', 'student.academicRecords');
        
        // Calculate promotion status if not already calculated
        if (!$returnee->academic_status) {
            $promotionStatus = $this->calculatePromotionStatus($returnee);
        } else {
            $promotionStatus = $returnee->academic_status;
        }
        
        return view('principal.returnees.show', compact('returnee', 'promotionStatus'));
    }

    // Approve application
    public function approve(Returnee $returnee)
    {
        $returnee->update(['status' => Returnee::STATUS_APPROVED]);
        
        // Update student status
        $returnee->student->update([
            'student_type' => Student::TYPE_RETURNEE,
            'status' => Student::STATUS_ACTIVE
        ]);

        // Create or update enrollment record
        Enrollment::updateOrCreate(
            [
                'student_id' => $returnee->student_id,
                'school_year' => '2024-2025'
            ],
            [
                'grade_level' => $returnee->new_grade_level,
                'enrollment_type' => Enrollment::TYPE_RETURNEE,
                'status' => Enrollment::STATUS_APPROVED,
                'remarks' => 'Returnee application approved by principal'
            ]
        );

        return redirect()->route('returnees.pending')->with('success', 'Returnee application approved successfully.');
    }

    // Reject application
    public function reject(Returnee $returnee)
    {
        $returnee->update(['status' => Returnee::STATUS_REJECTED]);
        
        // Update enrollment status if exists
        Enrollment::where('student_id', $returnee->student_id)
            ->where('school_year', '2024-2025')
            ->update([
                'status' => Enrollment::STATUS_REJECTED,
                'remarks' => 'Returnee application rejected by principal'
            ]);

        return redirect()->route('returnees.pending')->with('success', 'Returnee application rejected successfully.');
    }

    // Calculate promotion status for returnee
    private function calculatePromotionStatus(Returnee $returnee)
    {
        $records = AcademicRecord::where('student_id', $returnee->student_id)
            ->where('school_year', $returnee->previous_school_year)
            ->get();

        $failedSubjects = $records->filter(function ($record) {
            return $record->grade < 75;
        });

        $status = [
            'failed_count' => $failedSubjects->count(),
            'failed_subjects' => $failedSubjects->pluck('subject')->toArray(),
            'can_proceed' => $failedSubjects->count() <= 3,
            'average_grade' => $records->avg('grade') ? round($records->avg('grade'), 2) : 0,
            'status' => $failedSubjects->count() <= 3 ? 'eligible' : 'needs_review',
            'total_subjects' => $records->count()
        ];

        $returnee->update(['academic_status' => $status]);
        return $status;
    }
}