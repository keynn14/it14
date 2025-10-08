<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Transferee;
use App\Models\Returnee;
use App\Models\Student;
use Carbon\Carbon;

class PrincipalController extends Controller
{
    public function dashboard()
    {
        $currentYear = date('Y');
        $upcomingYear = $currentYear + 1;
        $currentSchoolYear = "{$currentYear}-{$upcomingYear}";
        
        // Get pending enrollments for current school year
        $pendingCurrent = Enrollment::where('school_year', $currentSchoolYear)
            ->where('status', Enrollment::STATUS_PENDING)
            ->count();

        // Get pending enrollments for upcoming school year
        $pendingUpcoming = Enrollment::where('school_year', "{$upcomingYear}-" . ($upcomingYear + 1))
            ->where('status', Enrollment::STATUS_PENDING)
            ->count();

        // Overall statistics
        $stats = [
            'total_students' => Student::count(),
            'active_enrollments' => Enrollment::active()->count(),
            'pending_enrollments' => Enrollment::pending()->count(),
            'pending_transferees' => Transferee::where('status', Transferee::STATUS_PENDING)->count(),
            'pending_returnees' => Returnee::count(), // You might want to add status field to returnees
        ];

        // Enrollment statistics by year
        $enrollmentStats = $this->getEnrollmentStats();
        
        // Recent pending enrollments
        $recentPending = Enrollment::pending()
            ->with('student')
            ->latest()
            ->take(5)
            ->get();

        return view('principal.dashboard', compact(
            'currentYear',
            'upcomingYear',
            'currentSchoolYear',
            'pendingCurrent',
            'pendingUpcoming',
            'stats',
            'enrollmentStats',
            'recentPending'
        ));
    }

    private function getEnrollmentStats()
    {
        $currentYear = date('Y');
        $years = [];
        
        // Get enrollment stats for current and previous 3 years
        for ($i = 3; $i >= 0; $i--) {
            $year = $currentYear - $i;
            $schoolYear = "{$year}-" . ($year + 1);
            
            $years[$schoolYear] = [
                'total' => Enrollment::where('school_year', $schoolYear)->count(),
                'approved' => Enrollment::where('school_year', $schoolYear)
                    ->where('status', Enrollment::STATUS_APPROVED)
                    ->count(),
                'pending' => Enrollment::where('school_year', $schoolYear)
                    ->where('status', Enrollment::STATUS_PENDING)
                    ->count(),
                'transferees' => Enrollment::where('school_year', $schoolYear)
                    ->where('enrollment_type', Enrollment::TYPE_TRANSFEREE)
                    ->count(),
                'returnees' => Enrollment::where('school_year', $schoolYear)
                    ->where('enrollment_type', Enrollment::TYPE_RETURNEE)
                    ->count(),
            ];
        }
        
        return $years;
    }

    public function pendingStudents()
    {
        $pendingEnrollments = Enrollment::pending()
            ->with('student')
            ->latest()
            ->get();
            
        return view('principal.pending-students', compact('pendingEnrollments'));
    }

    public function pendingTransferees()
    {
        $pendingTransferees = Transferee::with(['student', 'enrollment'])
            ->where('status', Transferee::STATUS_PENDING)
            ->latest()
            ->get();
            
        return view('principal.pending-transferees', compact('pendingTransferees'));
    }

    public function pendingReturnees()
    {
        $pendingReturnees = Returnee::with(['student', 'enrollment'])
            ->whereHas('enrollment', function($query) {
                $query->where('status', Enrollment::STATUS_PENDING);
            })
            ->latest()
            ->get();

        return view('principal.pending-returnees', compact('pendingReturnees'));
    }

    public function approve($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->update(['status' => Enrollment::STATUS_APPROVED]);
        $enrollment->student->update(['status' => Student::STATUS_ACTIVE]);

        return redirect()->back()->with('success', 'Student enrollment approved successfully.');
    }

    public function reject($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->update(['status' => Enrollment::STATUS_REJECTED]);

        return redirect()->back()->with('success', 'Student enrollment rejected.');
    }

    public function approveTransferee($id)
    {
        $transferee = Transferee::findOrFail($id);
        
        \Illuminate\Support\Facades\DB::transaction(function () use ($transferee) {
            $transferee->update(['status' => Transferee::STATUS_APPROVED]);
            
            $enrollment = Enrollment::where('student_id', $transferee->student_id)
                ->where('status', Enrollment::STATUS_PENDING)
                ->first();
                
            if ($enrollment) {
                $enrollment->update(['status' => Enrollment::STATUS_APPROVED]);
            }
            
            $transferee->student->update(['status' => Student::STATUS_ACTIVE]);
        });

        return redirect()->back()->with('success', 'Transferee application approved successfully.');
    }

    public function rejectTransferee($id)
    {
        $transferee = Transferee::findOrFail($id);
        $transferee->update(['status' => Transferee::STATUS_REJECTED]);

        return redirect()->back()->with('success', 'Transferee application rejected.');
    }

    public function approveReturnee($id)
    {
        $returnee = Returnee::findOrFail($id);
        
        $enrollment = Enrollment::where('student_id', $returnee->student_id)
            ->where('status', Enrollment::STATUS_PENDING)
            ->first();
            
        if ($enrollment) {
            $enrollment->update(['status' => Enrollment::STATUS_APPROVED]);
            $returnee->student->update(['status' => Student::STATUS_ACTIVE]);
        }

        return redirect()->back()->with('success', 'Returnee enrollment approved successfully.');
    }

    public function studentReports()
    {
        $students = Student::with(['enrollments', 'transfereeInfo', 'returneeInfo'])
            ->latest()
            ->get();
            
        $stats = [
            'total' => $students->count(),
            'active' => $students->where('status', Student::STATUS_ACTIVE)->count(),
            'inactive' => $students->where('status', Student::STATUS_INACTIVE)->count(),
            'by_type' => $students->groupBy('student_type')->map->count(),
            'by_grade' => $this->getStudentsByGradeLevel(),
        ];

        return view('principal.student-reports', compact('students', 'stats'));
    }

    private function getStudentsByGradeLevel()
    {
        return Enrollment::where('status', Enrollment::STATUS_APPROVED)
            ->where('school_year', date('Y') . '-' . (date('Y') + 1))
            ->get()
            ->groupBy('grade_level')
            ->map->count();
    }

    public function enrollmentReports()
    {
        $enrollments = Enrollment::with('student')->latest()->get();
        $stats = [
            'total' => $enrollments->count(),
            'approved' => $enrollments->where('status', Enrollment::STATUS_APPROVED)->count(),
            'pending' => $enrollments->where('status', Enrollment::STATUS_PENDING)->count(),
            'rejected' => $enrollments->where('status', Enrollment::STATUS_REJECTED)->count(),
            'by_type' => $enrollments->groupBy('enrollment_type')->map->count(),
            'by_grade' => $enrollments->groupBy('grade_level')->map->count(),
            'by_year' => $enrollments->groupBy('school_year')->map->count(),
        ];

        return view('principal.enrollment-reports', compact('enrollments', 'stats'));
    }
}