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
                    <form id="studentForm">
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
            // Update progress bar
            const progress = (currentStep / totalSteps) * 100;
            document.getElementById('progressBar').style.width = progress + '%';
            
            // Update text
            document.getElementById('currentStep').textContent = currentStep;
            document.getElementById('progressText').textContent = Math.round(progress) + '% Complete';
            
            // Update buttons
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
            // Hide all steps
            document.querySelectorAll('.step').forEach(stepElement => {
                stepElement.classList.add('hidden');
            });
            
            // Show current step
            document.getElementById('step' + step).classList.remove('hidden');
            
            currentStep = step;
            updateProgress();
        }

        function nextStep() {
    if (currentStep < totalSteps) {
        // Validate current step before proceeding
        if (validateStep(currentStep)) {
            showStep(currentStep + 1);
        }
    } else {
        // Submit form - check if terms are agreed
        if (document.getElementById('agreeTerms') && !document.getElementById('agreeTerms').checked) {
            alert('Please confirm that all information is accurate before submitting.');
            return;
        }
        
        // Here you would typically submit the form to your backend
        alert('Student registration submitted successfully!');
        // document.getElementById('studentForm').submit();
        // For now, just redirect back to enrollment page
        window.location.href = "{{ route('enrollment') }}";
    }
}

        function previousStep() {
            if (currentStep > 1) {
                showStep(currentStep - 1);
            }
        }

        function validateStep(step) {
            // Add validation logic for each step here
            // For now, always return true
            return true;
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            updateProgress();
        });
    </script>
</x-app-layout>