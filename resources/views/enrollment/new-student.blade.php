<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Register New Student') }}
            </h2>
            <a href="{{ route('enrollment') }}" class="bg-green-600 hover:bg-green-900 text-white py-2 px-4 rounded-lg">
                <i class="fas fa-arrow-left mr-2"></i> Back to Enrollment
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Progress Bar -->
                    <div class="mb-8">
                        <div class="flex justify-between mb-2">
                            <span class="text-sm font-semibold text-black-600">Step <span id="currentStep">1</span> of 6</span>
                            <span class="text-sm font-semibold text-black-600" id="progressText">16% Complete</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div id="progressBar" class="bg-green-600 h-3 rounded-full transition-all duration-300" style="width: 16%"></div>
                        </div>
                    </div>

                    <!-- Step Navigation -->
                    <div class="flex justify-between mb-8">
                        <button onclick="previousStep()" id="prevBtn" class="bg-green-600 hover:bg-green-900 text-white py-2 px-6 rounded-lg font-semibold hidden">
                            <i class="fas fa-arrow-left mr-2"></i> Previous
                        </button>
                        <button onclick="nextStep()" id="nextBtn" class="bg-green-600 hover:bg-green-900 text-white py-2 px-6 rounded-lg font-semibold ml-auto">
                            Next <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>

                    <!-- Form Steps -->
                    <!-- In new-student.blade.php, update the form section -->
<form id="studentForm" method="POST" action="{{ route('students.store') }}">
    @csrf
    
    <!-- Step 1: Learner Info -->
    <div id="step1" class="step">
        @include('enrollment.steps.learner-info')
    </div>

    <!-- Step 2: Address Info -->
    <div id="step2" class="step hidden">
        @include('enrollment.steps.address-info')
    </div>

    <!-- Step 3: Family Info -->
    <div id="step3" class="step hidden">
        @include('enrollment.steps.family-info')
    </div>

    <!-- Step 4: Disability Info -->
    <div id="step4" class="step hidden">
        @include('enrollment.steps.disability-info')
    </div>

    <!-- Step 5: Student Profile -->
    <div id="step5" class="step hidden">
        @include('enrollment.steps.student-profile')
    </div>

    <!-- Step 6: Finalize -->
    <div id="step6" class="step hidden">
        @include('enrollment.steps.finalize')
    </div>
</form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <script>
    let currentStep = 1;
    const totalSteps = 6;

    function updateProgress() {
        const progress = (currentStep / totalSteps) * 100;
        document.getElementById('progressBar').style.width = progress + '%';
        document.getElementById('currentStep').textContent = currentStep;
        document.getElementById('progressText').textContent = Math.round(progress) + '% Complete';
        
        document.getElementById('prevBtn').classList.toggle('hidden', currentStep === 1);
        
        if (currentStep === totalSteps) {
            document.getElementById('nextBtn').innerHTML = 'Submit <i class="fas fa-check ml-2"></i>';
            document.getElementById('nextBtn').classList.remove('bg-green-600');
            document.getElementById('nextBtn').classList.add('bg-green-600', 'hover:bg-green-900');
        } else {
            document.getElementById('nextBtn').innerHTML = 'Next <i class="fas fa-arrow-right ml-2"></i>';
            document.getElementById('nextBtn').classList.remove('bg-green-600', 'hover:bg-green-900');
            document.getElementById('nextBtn').classList.add('bg-green-600', 'hover:bg-green-900');
        }
    }

    function showStep(step) {
        document.querySelectorAll('.step').forEach(stepElement => {
            stepElement.classList.add('hidden');
        });
        
        document.getElementById('step' + step).classList.remove('hidden');
        currentStep = step;
        updateProgress();
        hideErrors();
    }

    function hideErrors() {
        // Remove error styling
        document.querySelectorAll('.border-red-500').forEach(field => {
            field.classList.remove('border-red-500', 'bg-red-50');
            field.classList.add('border-black-300');
        });
        
        document.querySelectorAll('.error-message').forEach(error => {
            error.remove();
        });
    }

    function markFieldError(fieldName, message) {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.classList.remove('border-black-300');
            field.classList.add('border-red-500', 'bg-red-50');
            
            const existingError = field.parentNode.querySelector('.error-message');
            if (existingError) {
                existingError.remove();
            }
            
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message text-red-600 text-sm mt-1';
            errorDiv.textContent = message;
            field.parentNode.appendChild(errorDiv);
        }
    }

    function validateStep(step) {
        hideErrors();
        const errors = [];

        switch(step) {
            case 1:
                // Learner Info validation
                const lastName = document.querySelector('[name="last_name"]');
                const firstName = document.querySelector('[name="first_name"]');
                const birthdate = document.querySelector('[name="birthdate"]');
                const gender = document.querySelector('[name="gender"]');
                
                if (!lastName.value.trim()) {
                    errors.push('Last name is required');
                    markFieldError('last_name', 'Last name is required');
                }
                
                if (!firstName.value.trim()) {
                    errors.push('First name is required');
                    markFieldError('first_name', 'First name is required');
                }
                
                if (!birthdate.value) {
                    errors.push('Birthdate is required');
                    markFieldError('birthdate', 'Birthdate is required');
                }
                
                if (!gender.value) {
                    errors.push('Gender is required');
                    markFieldError('gender', 'Gender is required');
                }
                break;

            case 2:
                // Address Info validation
                const streetAddress = document.querySelector('[name="street_address"]');
                const city = document.querySelector('[name="city"]');
                const state = document.querySelector('[name="state"]');
                const zipCode = document.querySelector('[name="zip_code"]');
                const country = document.querySelector('[name="country"]');
                
                if (!streetAddress.value.trim()) {
                    errors.push('Street address is required');
                    markFieldError('street_address', 'Street address is required');
                }
                
                if (!city.value.trim()) {
                    errors.push('City/Municipality is required');
                    markFieldError('city', 'City/Municipality is required');
                }
                
                if (!state.value.trim()) {
                    errors.push('State/Province is required');
                    markFieldError('state', 'State/Province is required');
                }
                
                if (!zipCode.value.trim()) {
                    errors.push('ZIP Code is required');
                    markFieldError('zip_code', 'ZIP Code is required');
                }
                
                if (!country.value.trim()) {
                    errors.push('Country is required');
                    markFieldError('country', 'Country is required');
                }
                break;

            case 3:
                // Family Info validation
                const guardianFirstName = document.querySelector('[name="guardian_first_name"]');
                const guardianLastName = document.querySelector('[name="guardian_last_name"]');
                const guardianContact = document.querySelector('[name="guardian_contact"]');
                
                if (!guardianFirstName.value.trim()) {
                    errors.push('Guardian first name is required');
                    markFieldError('guardian_first_name', 'Guardian first name is required');
                }
                
                if (!guardianLastName.value.trim()) {
                    errors.push('Guardian last name is required');
                    markFieldError('guardian_last_name', 'Guardian last name is required');
                }
                
                if (!guardianContact.value.trim()) {
                    errors.push('Guardian contact number is required');
                    markFieldError('guardian_contact', 'Guardian contact number is required');
                }
                break;

            case 5:
                // Student Profile validation
                const gradeLevel = document.querySelector('[name="grade_level"]');
                
                if (!gradeLevel.value) {
                    errors.push('Grade level is required');
                    markFieldError('grade_level', 'Grade level is required');
                }
                break;
        }

        if (errors.length > 0) {
            // Show first error by scrolling to it
            const firstErrorField = document.querySelector('.border-red-500');
            if (firstErrorField) {
                firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return false;
        }

        return true;
    }

    function nextStep() {
        if (currentStep < totalSteps) {
            if (validateStep(currentStep)) {
                showStep(currentStep + 1);
            }
        } else {
            // Final submission
            if (document.getElementById('agreeTerms') && !document.getElementById('agreeTerms').checked) {
                alert('Please confirm that all information is accurate before submitting.');
                return;
            }

            // Submit the form
            document.getElementById('studentForm').submit();
        }
    }

    function previousStep() {
        if (currentStep > 1) {
            hideErrors();
            showStep(currentStep - 1);
        }
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        updateProgress();
    });
</script>
</x-app-layout>