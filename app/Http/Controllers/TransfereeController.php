<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransfereeController extends Controller
{
    public function showInfoForm()
    {
        return view('enrollment/transferee-info');
    }

    public function processInfo(Request $request)
    {
        $validated = $request->validate([
            'lrn' => 'required|digits:12',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:50',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'contact_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string|max:500',
        ]);

        session()->put('transferee_data', $validated);
        session()->put('lrn', $request->lrn);

        return redirect()->route('transferee.academic');
    }

    public function showAcademicForm()
    {
        if (!session()->has('lrn')) {
            return redirect()->route('transferee.info')->with('error', 'Please complete student information first.');
        }

        return view('transferee-academic');
    }

    public function processAcademic(Request $request)
    {
        $validated = $request->validate([
            'lrn' => 'required|digits:12',  // Hidden field
            'previous_school' => 'required|string|max:255',
            'previous_school_address' => 'required|string|max:500',
            'school_type' => 'required|in:public,private',
            'previous_grade' => 'required|integer|between:7,12',
            'desired_grade' => 'required|integer|between:7,12',
            'last_school_year' => 'required|string|max:20',
            'transfer_reason' => 'required|string|max:1000',
        ]);

        $data = session('transferee_data', []);
        $data = array_merge($data, $validated);
        session()->put('transferee_data', $data);

        return redirect()->route('transferee.documents');
    }

    public function showDocumentsForm()
    {
        if (!session()->has('lrn')) {
            return redirect()->route('transferee.info')->with('error', 'Please complete previous steps first.');
        }

        return view('transferee-documents');
    }

    public function submitEnrollment(Request $request)
    {
        $validated = $request->validate([
            'lrn' => 'required|digits:12',  // Hidden field
            'form_137' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'good_moral' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'birth_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $data = session('transferee_data', []);

        // TODO: Save $data to database (e.g., Student model)
        // Store files: $form137Path = $request->file('form_137')->store('documents', 'public');

        // For demo:
        session()->flash('success', 'Enrollment submitted successfully!');

        // Clear session
        session()->forget(['transferee_data', 'lrn']);

        return redirect()->route('enrollment');
    }
}