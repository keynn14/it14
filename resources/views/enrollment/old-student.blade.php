<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #1f2937;">
                {{ __('Enroll Old Student') }}
            </h2>
            <a href="{{ route('enrollment') }}" style="display: inline-flex; align-items: center; background-color: #16a34a; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; text-decoration: none;" id="backButton" onmouseover="this.style.backgroundColor='#14532d'" onmouseout="this.style.backgroundColor='#16a34a'">
                <i class="fas fa-arrow-left" style="margin-right: 0.5rem;"></i> Back to Enrollment
            </a>
        </div>
    </x-slot>

    <!-- Add Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <div style="padding-top: 1.5rem; padding-bottom: 1.5rem;">
        <div style="max-width: 64rem; margin-left: auto; margin-right: auto; padding-left: 1.5rem; padding-right: 1.5rem;">
            <div style="background-color: white; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden;">
                <div style="padding: 1.5rem;">
                    <div style="text-align: left;">
                        <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem; color: #000000;">ENROLL OLD STUDENT</h2>
                        
                        <!-- SEARCH SECTION -->
                        <div style="margin-bottom: 1.5rem; padding: 1.5rem; border: 2px solid #16a34a; border-radius: 0.5rem; background-color: #ebfdf2;">
                            <label style="display: block; color: #000000; font-weight: 600; margin-bottom: 0.75rem; font-size: 1.125rem;">SEARCH: NAME/LRN</label>
                            <div style="display: flex; gap: 8px;">
                                <input type="text" id="searchInput" placeholder="Enter student name or LRN" style="flex: 1; border: 2px solid #16a34a; border-radius: 8px; padding: 12px 16px; font-size: 18px; font-weight: 600;">
                                <button onclick="searchStudent()" id="searchButton" style="background-color: #16a34a; color: white; padding: 12px 24px; border-radius: 8px; font-weight: 600; border: none; cursor: pointer;" onmouseover="this.style.backgroundColor='#14532d'" onmouseout="this.style.backgroundColor='#16a34a'">
                                    <i class="fas fa-search" style="margin-right: 8px;"></i> Search
                                </button>
                            </div>
                        </div>

                        <!-- LOADING SPINNER -->
                        <div id="loadingSpinner" style="display: none; text-align: center; padding: 2rem;">
                            <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: #16a34a;"></i>
                            <p style="margin-top: 1rem; color: #4b5563;">Searching for student...</p>
                        </div>

                        <!-- SEARCH RESULTS -->
                        <div id="searchResults" style="display: none;">
                            <!-- IF FOUND -->
                            <div id="foundSection" style="display: none;" class="mb-6 p-6 border-2 border-green-500 rounded-lg bg-green-50">
                                <h3 class="text-lg font-bold text-green-800 mb-4">STUDENT FOUND</h3>
                                
                                <!-- Student Details -->
                                <div class="mb-4 p-4 bg-white rounded-lg border border-green-300">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label class="block text-gray-700 font-semibold mb-2">NAME:</label>
                                            <div class="bg-yellow-100 px-4 py-2 rounded font-semibold" id="foundName">-</div>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700 font-semibold mb-2">LRN:</label>
                                            <div class="bg-gray-100 px-4 py-2 rounded font-semibold" id="foundLRN">-</div>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700 font-semibold mb-2">GRADE LEVEL:</label>
                                            <div class="bg-gray-100 px-4 py-2 rounded font-semibold" id="foundGrade">-</div>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700 font-semibold mb-2">SECTION:</label>
                                            <div class="bg-gray-100 px-4 py-2 rounded font-semibold" id="foundSection">-</div>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700 font-semibold mb-2">GENDER:</label>
                                            <div class="bg-gray-100 px-4 py-2 rounded font-semibold" id="foundGender">-</div>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700 font-semibold mb-2">BIRTHDATE:</label>
                                            <div class="bg-gray-100 px-4 py-2 rounded font-semibold" id="foundBirthdate">-</div>
                                        </div>
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="flex gap-2">
                                        <button onclick="showUpdateForm()" class="bg-green-600 hover:bg-green-700 text-white py-2 px-6 rounded-lg font-semibold">
                                            <i class="fas fa-edit mr-2"></i> UPDATE
                                        </button>
                                        <button onclick="enrollStudent()" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-lg font-semibold">
                                            <i class="fas fa-check mr-2"></i> ENROLL
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- UPDATE FORM (Hidden by default) -->
                            <div id="updateForm" style="display: none;" class="mb-6 p-6 border-2 border-purple-500 rounded-lg bg-purple-50">
                                <h3 class="text-lg font-bold text-purple-800 mb-4">UPDATE STUDENT INFO</h3>
                                
                                <div class="bg-white p-4 rounded-lg border border-purple-300">
                                    <form id="updateStudentForm">
                                        @csrf
                                        <input type="hidden" id="updateLearnerId">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <label class="block text-gray-700 font-semibold mb-2">LAST NAME:</label>
                                                <input type="text" id="updateLastName" class="w-full border-2 border-gray-300 rounded-lg px-4 py-2" required>
                                            </div>
                                            <div>
                                                <label class="block text-gray-700 font-semibold mb-2">FIRST NAME:</label>
                                                <input type="text" id="updateFirstName" class="w-full border-2 border-gray-300 rounded-lg px-4 py-2" required>
                                            </div>
                                            <div>
                                                <label class="block text-gray-700 font-semibold mb-2">MIDDLE NAME:</label>
                                                <input type="text" id="updateMiddleName" class="w-full border-2 border-gray-300 rounded-lg px-4 py-2">
                                            </div>
                                            <div>
                                                <label class="block text-gray-700 font-semibold mb-2">LRN:</label>
                                                <input type="text" id="updateLRN" class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 bg-gray-100" readonly>
                                            </div>
                                            <div>
                                                <label class="block text-gray-700 font-semibold mb-2">BIRTHDATE:</label>
                                                <input type="date" id="updateBirthdate" class="w-full border-2 border-gray-300 rounded-lg px-4 py-2" required>
                                            </div>
                                            <div>
                                                <label class="block text-gray-700 font-semibold mb-2">GENDER:</label>
                                                <select id="updateGender" class="w-full border-2 border-gray-300 rounded-lg px-4 py-2" required>
                                                    <option value="">Select Gender</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                </select>
                                            </div>
                                            <div class="md:col-span-2">
                                                <label class="block text-gray-700 font-semibold mb-2">ADDRESS:</label>
                                                <textarea id="updateAddress" class="w-full border-2 border-gray-300 rounded-lg px-4 py-2" rows="2"></textarea>
                                            </div>
                                            <div>
                                                <label class="block text-gray-700 font-semibold mb-2">GUARDIAN NAME:</label>
                                                <input type="text" id="updateGuardian" class="w-full border-2 border-gray-300 rounded-lg px-4 py-2">
                                            </div>
                                            <div>
                                                <label class="block text-gray-700 font-semibold mb-2">GUARDIAN CONTACT:</label>
                                                <input type="text" id="updateContact" class="w-full border-2 border-gray-300 rounded-lg px-4 py-2">
                                            </div>
                                        </div>
                                        
                                        <div class="flex gap-2 justify-end">
                                            <button type="button" onclick="cancelUpdate()" class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-6 rounded-lg font-semibold">
                                                CANCEL
                                            </button>
                                            <button type="button" onclick="submitUpdate()" class="bg-green-600 hover:bg-green-700 text-white py-2 px-6 rounded-lg font-semibold">
                                                SUBMIT UPDATE
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- NOT FOUND -->
                            <div id="notFoundSection" style="display: none; padding: 1.5rem; border: 2px solid #ef4444; border-radius: 0.5rem; background-color: #fef2f2;">
                                <h3 style="font-size: 1.125rem; font-weight: 700; color: #991b1b; margin-bottom: 1rem;">STUDENT NOT FOUND</h3>
                                <div style="text-align: center; padding-top: 1.5rem; padding-bottom: 1.5rem;">
                                    <i class="fas fa-search" style="color: #ef4444; font-size: 2.25rem; margin-bottom: 1rem; display: block;"></i>
                                    <p style="color: #dc2626; margin-bottom: 1.5rem; font-size: 1rem;">No student found with the provided name or LRN.</p>
                                    <a href="{{ route('enrollment.new-student') }}" style="display: inline-flex; align-items: center; justify-content: center; background-color: #16a34a; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600; font-size: 1.125rem; text-decoration: none;" id="registerButton" onmouseover="this.style.backgroundColor='#15803d'" onmouseout="this.style.backgroundColor='#16a34a'">
                                        <i class="fas fa-user-plus" style="margin-right: 0.5rem;"></i> REGISTER AS NEW STUDENT
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    let currentStudentId = null;
    let isAlreadyEnrolled = false;

    function searchStudent() {
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const searchResults = document.getElementById('searchResults');
        const foundSection = document.getElementById('foundSection');
        const notFoundSection = document.getElementById('notFoundSection');
        
        if (!searchInput.value.trim()) {
            alert('Please enter a student name, LRN, or ID to search.');
            return;
        }
        
        // Show loading, hide other sections
        loadingSpinner.style.display = 'block';
        searchResults.style.display = 'none';
        foundSection.style.display = 'none';
        notFoundSection.style.display = 'none';
        searchButton.disabled = true;
        searchButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Searching...';
        
        console.log('Searching for:', searchInput.value.trim());
        
        // Make AJAX request to search for student
        fetch('{{ route("enrollment.search-student") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                search_term: searchInput.value.trim()
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Search response:', data);
            loadingSpinner.style.display = 'none';
            searchButton.disabled = false;
            searchButton.innerHTML = '<i class="fas fa-search mr-2"></i> Search';
            searchResults.style.display = 'block';
            
            if (data.success && data.student) {
                // Student found
                displayStudentData(data.student, data.is_already_enrolled, data.current_enrollment);
                foundSection.style.display = 'block';
                notFoundSection.style.display = 'none';
            } else {
                // Student not found
                foundSection.style.display = 'none';
                notFoundSection.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            loadingSpinner.style.display = 'none';
            searchButton.disabled = false;
            searchButton.innerHTML = '<i class="fas fa-search mr-2"></i> Search';
            alert('Error searching for student. Please try again.');
        });
    }
    
    function displayStudentData(student, alreadyEnrolled, currentEnrollment) {
        currentStudentId = student.id;
        isAlreadyEnrolled = alreadyEnrolled;
        
        console.log('Displaying student:', student);
        console.log('Already enrolled:', alreadyEnrolled);
        console.log('Current enrollment:', currentEnrollment);
        
        // Display basic student info
        const fullName = `${student.last_name}, ${student.first_name}${student.middle_name ? ' ' + student.middle_name : ''}${student.extension_name ? ' ' + student.extension_name : ''}`;
        document.getElementById('foundName').textContent = fullName;
        document.getElementById('foundLRN').textContent = student.lrn || 'N/A';
        document.getElementById('foundGender').textContent = student.gender ? student.gender.charAt(0).toUpperCase() + student.gender.slice(1) : 'N/A';
        document.getElementById('foundBirthdate').textContent = student.birthdate ? new Date(student.birthdate).toLocaleDateString() : 'N/A';
        
        // Display student profile info if available
        if (student.student_profile) {
            document.getElementById('foundGrade').textContent = `Grade ${student.student_profile.grade_level}`;
            document.getElementById('foundSection').textContent = student.student_profile.section || 'N/A';
        } else {
            document.getElementById('foundGrade').textContent = 'Not assigned';
            document.getElementById('foundSection').textContent = 'Not assigned';
        }
        
        // Show enrollment status if already enrolled
        const actionButtons = document.querySelector('#foundSection .flex.gap-2');
        if (isAlreadyEnrolled) {
            const enrollmentStatus = currentEnrollment?.status || 'pending';
            const statusMessage = enrollmentStatus === 'approved' ? 
                'Already enrolled and approved for current school year' : 
                'Enrollment pending approval for current school year';
            
            // Disable enroll button and show status
            actionButtons.innerHTML = `
                <button onclick="showUpdateForm()" class="bg-green-600 hover:bg-green-700 text-white py-2 px-6 rounded-lg font-semibold">
                    <i class="fas fa-edit mr-2"></i> UPDATE INFO
                </button>
                <button disabled class="bg-gray-400 text-white py-2 px-6 rounded-lg font-semibold cursor-not-allowed">
                    <i class="fas fa-info-circle mr-2"></i> ${statusMessage.toUpperCase()}
                </button>
            `;
        } else {
            // Enable both buttons if not enrolled
            actionButtons.innerHTML = `
                <button onclick="showUpdateForm()" class="bg-green-600 hover:bg-green-700 text-white py-2 px-6 rounded-lg font-semibold">
                    <i class="fas fa-edit mr-2"></i> UPDATE INFO
                </button>
                <button onclick="showEnrollForm()" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-lg font-semibold">
                    <i class="fas fa-check mr-2"></i> ENROLL
                </button>
            `;
        }
        
        // Populate update form with current data for easier editing
        document.getElementById('updateLastName').value = student.last_name || '';
        document.getElementById('updateFirstName').value = student.first_name || '';
        document.getElementById('updateMiddleName').value = student.middle_name || '';
        document.getElementById('updateLRN').value = student.lrn || '';
        document.getElementById('updateBirthdate').value = student.birthdate || '';
        document.getElementById('updateGender').value = student.gender || '';
        
        // Populate additional fields if available
        if (student.address) {
            document.getElementById('updateAddress').value = `${student.address.street_address}, ${student.address.city}, ${student.address.state} ${student.address.zip_code}` || '';
        }
        
        if (student.family_background) {
            document.getElementById('updateGuardian').value = `${student.family_background.guardian_first_name} ${student.family_background.guardian_last_name}` || '';
            document.getElementById('updateContact').value = student.family_background.guardian_contact || '';
        }
    }
    
    function showUpdateForm() {
        const updateForm = document.getElementById('updateForm');
        const foundSection = document.getElementById('foundSection');
        const enrollForm = document.getElementById('enrollForm');
        
        updateForm.style.display = 'block';
        foundSection.style.display = 'none';
        if (enrollForm) enrollForm.style.display = 'none';
    }
    
    function showEnrollForm() {
        if (isAlreadyEnrolled) {
            alert('This student is already enrolled for the current school year.');
            return;
        }
        
        const enrollForm = document.getElementById('enrollForm');
        const foundSection = document.getElementById('foundSection');
        const updateForm = document.getElementById('updateForm');
        
        // Create enroll form if it doesn't exist
        if (!enrollForm) {
            createEnrollForm();
        }
        
        enrollForm.style.display = 'block';
        foundSection.style.display = 'none';
        if (updateForm) updateForm.style.display = 'none';
    }
    
    function createEnrollForm() {
        const searchResults = document.getElementById('searchResults');
        
        const enrollFormHTML = `
            <div id="enrollForm" style="display: none;" class="mb-6 p-6 border-2 border-blue-500 rounded-lg bg-blue-50">
                <h3 class="text-lg font-bold text-blue-800 mb-4">ENROLL STUDENT FOR CURRENT SCHOOL YEAR</h3>
                
                <div class="bg-white p-4 rounded-lg border border-blue-300">
                    <div class="mb-4">
                        <p class="text-gray-700 mb-2"><strong>Student:</strong> <span id="enrollStudentName">-</span></p>
                        <p class="text-gray-700 mb-4"><strong>LRN:</strong> <span id="enrollStudentLRN">-</span></p>
                    </div>
                    
                    <form id="enrollStudentForm">
                        @csrf
                        <input type="hidden" id="enrollLearnerId">
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">GRADE LEVEL:</label>
                            <select id="enrollGradeLevel" class="w-full border-2 border-gray-300 rounded-lg px-4 py-2" required>
                                <option value="">Select Grade Level</option>
                                <option value="7">Grade 7</option>
                                <option value="8">Grade 8</option>
                                <option value="9">Grade 9</option>
                                <option value="10">Grade 10</option>
                                <option value="11">Grade 11</option>
                                <option value="12">Grade 12</option>
                            </select>
                        </div>
                        
                        <div class="flex gap-2 justify-end">
                            <button type="button" onclick="cancelEnroll()" class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-6 rounded-lg font-semibold">
                                CANCEL
                            </button>
                            <button type="button" onclick="submitEnrollment()" class="bg-green-600 hover:bg-green-700 text-white py-2 px-6 rounded-lg font-semibold">
                                SUBMIT ENROLLMENT
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        `;
        
        // Insert after the update form
        const updateForm = document.getElementById('updateForm');
        updateForm.insertAdjacentHTML('afterend', enrollFormHTML);
        
        // Populate student info in enroll form
        document.getElementById('enrollStudentName').textContent = document.getElementById('foundName').textContent;
        document.getElementById('enrollStudentLRN').textContent = document.getElementById('foundLRN').textContent;
        document.getElementById('enrollLearnerId').value = currentStudentId;
    }
    
    function cancelUpdate() {
        const updateForm = document.getElementById('updateForm');
        const foundSection = document.getElementById('foundSection');
        const enrollForm = document.getElementById('enrollForm');
        
        updateForm.style.display = 'none';
        foundSection.style.display = 'block';
        if (enrollForm) enrollForm.style.display = 'none';
    }
    
    function cancelEnroll() {
        const enrollForm = document.getElementById('enrollForm');
        const foundSection = document.getElementById('foundSection');
        const updateForm = document.getElementById('updateForm');
        
        if (enrollForm) enrollForm.style.display = 'none';
        foundSection.style.display = 'block';
        if (updateForm) updateForm.style.display = 'none';
    }
    
    function submitUpdate() {
        const formData = {
            learner_id: currentStudentId,
            last_name: document.getElementById('updateLastName').value,
            first_name: document.getElementById('updateFirstName').value,
            middle_name: document.getElementById('updateMiddleName').value,
            lrn: document.getElementById('updateLRN').value,
            birthdate: document.getElementById('updateBirthdate').value,
            gender: document.getElementById('updateGender').value
        };
        
        // Validate required fields
        if (!formData.last_name || !formData.first_name) {
            alert('Please fill in both Last Name and First Name.');
            return;
        }
        
        fetch('{{ route("students.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Student information updated successfully!');
                // Refresh the search to show updated data
                searchStudent();
                cancelUpdate();
            } else {
                alert('Error updating student: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating student information.');
        });
    }
    
    function submitEnrollment() {
        const gradeLevel = document.getElementById('enrollGradeLevel').value;
        
        if (!gradeLevel) {
            alert('Please select a grade level.');
            return;
        }
        
        if (!currentStudentId) {
            alert('No student selected.');
            return;
        }
        
        const studentName = document.getElementById('foundName').textContent;
        
        if (confirm(`Submit enrollment for ${studentName} in Grade ${gradeLevel} for the current school year?`)) {
            fetch('{{ route("enrollment.enroll-returnee") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    learner_id: currentStudentId,
                    grade_level: gradeLevel
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message || 'Enrollment request submitted successfully!');
                    window.location.href = "{{ route('enrollment') }}";
                } else {
                    alert('Error submitting enrollment: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error submitting enrollment request.');
            });
        }
    }
    
    // Enter key support for search
    document.getElementById('searchInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchStudent();
        }
    });
    
    // Clear results when input changes
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchResults = document.getElementById('searchResults');
        searchResults.style.display = 'none';
    });
</script>
</x-app-layout>