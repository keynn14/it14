<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Student;

class EnrollmentController extends Controller
{
    public function dashboard()
    {
        return view('enrollment');
    }

    public function index()
    {
        $enrollments = Enrollment::with('student')->latest()->paginate(20);
        return view('enrollments.index', compact('enrollments'));
    }

    public function pending()
    {
        $enrollments = Enrollment::pending()->with('student')->latest()->paginate(20);
        return view('enrollments.pending', compact('enrollments'));
    }

    public function active()
    {
        $enrollments = Enrollment::active()->with('student')->latest()->paginate(20);
        return view('enrollments.active', compact('enrollments'));
    }

    public function approve(Enrollment $enrollment)
    {
        $enrollment->update(['status' => Enrollment::STATUS_APPROVED]);
        $enrollment->student->update(['status' => Student::STATUS_ACTIVE]);

        return redirect()->back()->with('success', 'Enrollment approved successfully.');
    }

    public function reject(Enrollment $enrollment)
    {
        $enrollment->update(['status' => Enrollment::STATUS_REJECTED]);

        return redirect()->back()->with('success', 'Enrollment rejected.');
    }

    public function cancel(Enrollment $enrollment)
    {
        $enrollment->update(['status' => Enrollment::STATUS_REJECTED]);

        return redirect()->back()->with('success', 'Enrollment cancelled.');
    }

    public function enrollmentReport()
    {
        $enrollments = Enrollment::with('student')->get();
        $stats = [
            'total' => $enrollments->count(),
            'approved' => $enrollments->where('status', Enrollment::STATUS_APPROVED)->count(),
            'pending' => $enrollments->where('status', Enrollment::STATUS_PENDING)->count(),
            'rejected' => $enrollments->where('status', Enrollment::STATUS_REJECTED)->count(),
            'by_type' => $enrollments->groupBy('enrollment_type')->map->count(),
        ];

        return view('reports.enrollment', compact('enrollments', 'stats'));
    }

    // Keep these for backward compatibility
    public function searchStudent(Request $request)
    {
        // Your existing search student logic
    }

    public function enrollReturnee(Request $request)
    {
        // Your existing enroll returnee logic
    }
}