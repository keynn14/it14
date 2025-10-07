<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;

class PrincipalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:principal']);
    }

    public function dashboard()
    {
        $currentYear = $this->getCurrentSchoolYear();
        $upcomingYear = $this->getUpcomingSchoolYear();

        $pendingCurrent = Enrollment::where('status', 'pending')
            ->where('school_year', $currentYear)
            ->count();

        $pendingUpcoming = Enrollment::where('status', 'pending')
            ->where('school_year', $upcomingYear)
            ->count();

        return view('principal.dashboard', compact('pendingCurrent', 'pendingUpcoming', 'currentYear', 'upcomingYear'));
    }

    public function pendingStudents()
    {
        $pendingEnrollments = Enrollment::where('status', 'pending')
            ->with('student')
            ->get();

        return view('principal.pending-students', compact('pendingEnrollments'));
    }

    public function approve(Request $request, $id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->status = 'approved';
        $enrollment->save();

        return redirect()->route('principal.pending-students')->with('success', 'Enrollment approved.');
    }

    public function reject(Request $request, $id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->status = 'rejected';
        $enrollment->save();

        return redirect()->route('principal.pending-students')->with('success', 'Enrollment rejected.');
    }

    private function getCurrentSchoolYear()
    {
        $year = date('Y');
        $month = date('m');
        return ($month >= 6) ? "$year-" . ($year + 1) : ($year - 1) . "-$year";
    }

    private function getUpcomingSchoolYear()
    {
        $year = date('Y');
        $month = date('m');
        return ($month >= 6) ? ($year + 1) . "-" . ($year + 2) : "$year-" . ($year + 1);
    }
}