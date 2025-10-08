<?php

namespace App\Http\Controllers\Principal;

use App\Http\Controllers\Controller;
use App\Models\Transferee;
use App\Models\Student;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class TransfereeController extends Controller
{
    public function index()
    {
        $transferees = Transferee::with('student')->latest()->get();
        return view('principal.transferees.index', compact('transferees'));
    }

    public function pending()
    {
        $transferees = Transferee::with('student')
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('principal.pending.Transferees', compact('transferees'));
    }

    public function show(Transferee $transferee)
    {
        $transferee->load('student', 'student.academicRecords');
        return view('principal.transferees.show', compact('transferee'));
    }

    public function approve(Transferee $transferee)
    {
        $transferee->update(['status' => 'approved']);
        
        $transferee->student->update([
            'student_type' => Student::TYPE_TRANSFEREE,
            'status' => Student::STATUS_ACTIVE
        ]);

        Enrollment::updateOrCreate(
            [
                'student_id' => $transferee->student_id,
                'school_year' => '2024-2025'
            ],
            [
                'grade_level' => $transferee->desired_grade,
                'enrollment_type' => Enrollment::TYPE_TRANSFEREE,
                'status' => Enrollment::STATUS_APPROVED,
                'remarks' => 'Transferee application approved by principal'
            ]
        );

        return redirect()->route('transferees.pending')->with('success', 'Transferee application approved successfully.');
    }

    public function reject(Transferee $transferee)
    {
        $transferee->update(['status' => 'rejected']);
        
        Enrollment::where('student_id', $transferee->student_id)
            ->where('school_year', '2024-2025')
            ->update([
                'status' => Enrollment::STATUS_REJECTED,
                'remarks' => 'Transferee application rejected by principal'
            ]);

        return redirect()->route('transferees.pending')->with('success', 'Transferee application rejected successfully.');
    }
}