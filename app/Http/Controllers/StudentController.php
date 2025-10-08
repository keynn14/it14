<?php
// app/Http/Controllers/StudentController.php

namespace App\Http\Controllers;

use App\Models\Learner;
use App\Models\Address;
use App\Models\FamilyBackground;
use App\Models\DisabilityInformation;
use App\Models\StudentProfile;
use App\Models\EnrollmentRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        // Validate the required fields
        $validated = $request->validate([
            // Learner Info
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'gender' => 'required|in:male,female',
            
            // Address Info
            'street_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            
            // Family Info
            'guardian_first_name' => 'required|string|max:255',
            'guardian_last_name' => 'required|string|max:255',
            'guardian_contact' => 'required|string|max:20',
            
            // Student Profile
            'grade_level' => 'required|in:7,8,9,10,11,12',
        ]);

        try {
            DB::beginTransaction();

            // Step 1: Create Learner
            $learner = Learner::create([
                'psa_birth_certificate' => $request->psa_birth_certificate,
                'last_name' => $request->last_name,
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'extension_name' => $request->extension_name,
                'lrn' => $request->lrn,
                'birthdate' => $request->birthdate,
                'gender' => $request->gender,
                'age' => $request->age,
                'ip_community' => $request->ip_community ?? 'no',
                'ip_specify' => $request->ip_specify,
                'fourps_beneficiary' => $request->fourps_beneficiary ?? 'no',
                'fourps_household_id' => $request->fourps_household_id,
                'mother_tongue' => $request->mother_tongue,
            ]);

            // Step 2: Create Address
            $learner->address()->create([
                'street_address' => $request->street_address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'country' => $request->country,
            ]);

            // Step 3: Create Family Background
            $learner->familyBackground()->create([
                'father_last_name' => $request->father_last_name,
                'father_first_name' => $request->father_first_name,
                'father_middle_name' => $request->father_middle_name,
                'father_contact' => $request->father_contact,
                'mother_last_name' => $request->mother_last_name,
                'mother_first_name' => $request->mother_first_name,
                'mother_middle_name' => $request->mother_middle_name,
                'mother_contact' => $request->mother_contact,
                'guardian_last_name' => $request->guardian_last_name,
                'guardian_first_name' => $request->guardian_first_name,
                'guardian_middle_name' => $request->guardian_middle_name,
                'guardian_contact' => $request->guardian_contact,
            ]);

            // Step 4: Create Disability Information
            $learner->disabilityInformation()->create([
                'disability_type' => $request->disability_type ?? 'none',
                'special_requirements' => $request->special_requirements,
                'medical_conditions' => $request->medical_conditions,
            ]);

            // Step 5: Create Student Profile
            $learner->studentProfile()->create([
                'grade_level' => $request->grade_level,
                'section' => $request->section,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            // Step 6: Create Enrollment Record
            $learner->enrollmentRecord()->create([
                'school_year' => $this->getCurrentSchoolYear(),
                'status' => 'pending',
                'terms_accepted' => true,
                'submitted_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('enrollment')
                ->with('success', 'Student registration submitted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Student registration failed: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to submit student registration. Please try again.');
        }
    }
    public function getStudent($id)
{
    $student = Learner::with(['address', 'familyBackground', 'studentProfile'])
        ->find($id);

    if (!$student) {
        return response()->json([
            'success' => false,
            'message' => 'Student not found'
        ], 404);
    }

    return response()->json($student);
}

// Add this method to your StudentController.php
public function updateStudent(Request $request)
{
    $request->validate([
        'learner_id' => 'required|exists:learners,id',
        'last_name' => 'required|string|max:255',
        'first_name' => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'lrn' => 'nullable|string|max:20',
        'birthdate' => 'nullable|date',
        'gender' => 'nullable|in:male,female',
    ]);

    try {
        DB::beginTransaction();

        $learner = Learner::find($request->learner_id);
        $updateData = [
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'lrn' => $request->lrn,
        ];

        // Only update these if provided
        if ($request->birthdate) {
            $updateData['birthdate'] = $request->birthdate;
        }
        if ($request->gender) {
            $updateData['gender'] = $request->gender;
        }

        $learner->update($updateData);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Failed to update student: ' . $e->getMessage()
        ], 500);
    }
}

    private function getCurrentSchoolYear()
    {
        $currentYear = date('Y');
        $nextYear = $currentYear + 1;
        return $currentYear . '-' . $nextYear;
    }
}