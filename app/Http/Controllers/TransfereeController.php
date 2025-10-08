<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Transferee;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransfereeController extends Controller
{
    public function showInfoForm()
    {
        return view('enrollment.transferee-info');
    }

    public function processInfo(Request $request)
    {
        Log::info('Transferee Step 1 - Form submitted', $request->all());

        $validated = $request->validate([
            'lrn' => 'required|digits:12|unique:students,lrn',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:50',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string|max:500',
        ]);

        Log::info('Transferee Step 1 - Validation passed', $validated);

        session()->put('transferee_data', $validated);
        session()->put('lrn', $request->lrn);

        Log::info('Transferee Step 1 - Session data stored', [
            'lrn' => session('lrn'),
            'has_data' => session()->has('transferee_data')
        ]);

        return redirect()->route('transferee.academic');
    }

    public function showAcademicForm()
    {
        Log::info('Transferee Step 2 - Accessing academic form', [
            'has_lrn' => session()->has('lrn'),
            'lrn' => session('lrn')
        ]);

        if (!session()->has('lrn')) {
            return redirect()->route('transferee.info')->with('error', 'Please complete student information first.');
        }

        return view('enrollment.transferee-academic');
    }

    public function processAcademic(Request $request)
    {
        Log::info('Transferee Step 2 - Academic form submitted', $request->all());

        $validated = $request->validate([
            'lrn' => 'required|digits:12',
            'previous_school' => 'required|string|max:255',
            'previous_school_address' => 'required|string|max:500',
            'school_type' => 'required|in:public,private',
            'previous_grade' => 'required|integer|between:7,12',
            'desired_grade' => 'required|integer|between:7,12',
            'last_school_year' => 'required|string|max:20',
            'transfer_reason' => 'required|string|max:1000',
        ]);

        if ($request->lrn !== session('lrn')) {
            Log::warning('Transferee Step 2 - LRN mismatch', [
                'session_lrn' => session('lrn'),
                'request_lrn' => $request->lrn
            ]);
            return redirect()->back()->with('error', 'LRN mismatch. Please start over.');
        }

        $data = session('transferee_data', []);
        $data = array_merge($data, $validated);
        session()->put('transferee_data', $data);

        Log::info('Transferee Step 2 - Academic data merged', [
            'merged_data_keys' => array_keys($data)
        ]);

        return redirect()->route('transferee.documents');
    }

    public function showDocumentsForm()
    {
        Log::info('Transferee Step 3 - Accessing documents form', [
            'has_lrn' => session()->has('lrn'),
            'has_data' => session()->has('transferee_data')
        ]);

        if (!session()->has('lrn')) {
            return redirect()->route('transferee.info')->with('error', 'Please complete previous steps first.');
        }

        return view('enrollment.transferee-documents');
    }

    public function submitEnrollment(Request $request)
    {
        $validated = $request->validate([
            'lrn' => 'required|digits:12',
            'form_137' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'good_moral' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'birth_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->lrn !== session('lrn')) {
            return redirect()->back()->with('error', 'LRN mismatch. Please start over.');
        }

        $data = session('transferee_data', []);

        try {
            DB::transaction(function () use ($data, $request) {
                // Create student record with correct status values
                $student = Student::create([
                    'lrn' => $data['lrn'],
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'middle_name' => $data['middle_name'] ?? null,
                    'birth_date' => $data['birth_date'],
                    'gender' => $data['gender'],
                    'address' => $data['address'],
                    'phone' => $data['phone'],
                    'email' => $data['email'] ?? null,
                    'student_type' => Student::TYPE_TRANSFEREE, // Use constant
                    'status' => Student::STATUS_ACTIVE, // Use 'active' not 'pending'
                ]);

                // Store documents
                $form137Path = $request->file('form_137')->store('documents/transferees/form137', 'public');
                $goodMoralPath = $request->file('good_moral')->store('documents/transferees/good_moral', 'public');
                $birthCertificatePath = $request->file('birth_certificate') ? 
                    $request->file('birth_certificate')->store('documents/transferees/birth_certificate', 'public') : null;

                // Create transferee record
                $transferee = Transferee::create([
                    'student_id' => $student->id,
                    'previous_school' => $data['previous_school'],
                    'previous_school_address' => $data['previous_school_address'],
                    'school_type' => $data['school_type'],
                    'previous_grade' => $data['previous_grade'],
                    'desired_grade' => $data['desired_grade'],
                    'last_school_year' => $data['last_school_year'],
                    'transfer_reason' => $data['transfer_reason'],
                    'form_137_path' => $form137Path,
                    'good_moral_path' => $goodMoralPath,
                    'birth_certificate_path' => $birthCertificatePath,
                    'status' => Transferee::STATUS_PENDING,
                ]);

                // Create pending enrollment
                Enrollment::create([
                    'student_id' => $student->id,
                    'school_year' => '2024-2025',
                    'grade_level' => $data['desired_grade'],
                    'enrollment_type' => Enrollment::TYPE_TRANSFEREE,
                    'status' => Enrollment::STATUS_PENDING, // Use constant
                    'remarks' => 'Pending document verification'
                ]);
            });

            session()->flash('success', 'Enrollment submitted successfully! Your application is pending verification.');

            // Clear session
            session()->forget(['transferee_data', 'lrn']);

            return redirect()->route('enrollment');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error submitting enrollment: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $transferees = Transferee::with('student')->latest()->paginate(20);
        return view('transferees.index', compact('transferees'));
    }

    public function pending()
    {
        $transferees = Transferee::with('student')
            ->where('status', Transferee::STATUS_PENDING)
            ->latest()
            ->paginate(20);
        return view('principal.pending.Transferees', compact('transferees'));
    }

    public function show(Transferee $transferee)
    {
        $transferee->load('student', 'enrollment');
        return view('transferees.show', compact('transferee'));
    }

    public function approve(Transferee $transferee)
    {
        DB::transaction(function () use ($transferee) {
            $transferee->update(['status' => Transferee::STATUS_APPROVED]);
            
            // Update student status
            $transferee->student->update(['status' => Student::STATUS_ACTIVE]);
            
            // Update enrollment status
            $enrollment = Enrollment::where('student_id', $transferee->student_id)
                ->where('status', Enrollment::STATUS_PENDING)
                ->first();
                
            if ($enrollment) {
                $enrollment->update(['status' => Enrollment::STATUS_APPROVED]); // Use 'approved' not 'active'
            }
        });

        return redirect()->back()->with('success', 'Transferee application approved successfully.');
    }

    public function reject(Transferee $transferee)
    {
        $transferee->update(['status' => Transferee::STATUS_REJECTED]);
        return redirect()->back()->with('success', 'Transferee application rejected.');
    }

    public function transfereeReport()
    {
        $transferees = Transferee::with('student')->get();
        $stats = [
            'total' => $transferees->count(),
            'pending' => $transferees->where('status', Transferee::STATUS_PENDING)->count(),
            'approved' => $transferees->where('status', Transferee::STATUS_APPROVED)->count(),
            'rejected' => $transferees->where('status', Transferee::STATUS_REJECTED)->count(),
            'by_school_type' => $transferees->groupBy('school_type')->map->count(),
        ];

        return view('reports.transferees', compact('transferees', 'stats'));
    }
}