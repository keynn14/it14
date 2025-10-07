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
                                <button onclick="searchStudent()" style="background-color: #16a34a; color: white; padding: 12px 24px; border-radius: 8px; font-weight: 600; border: none; cursor: pointer;" onmouseover="this.style.backgroundColor='#14532d'" onmouseout="this.style.backgroundColor='#16a34a'">
                                    <i class="fas fa-search" style="margin-right: 8px;"></i> Search
                                </button>
                            </div>
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
                                            <div class="bg-yellow-100 px-4 py-2 rounded font-semibold" id="foundName">KARL PITMLS</div>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700 font-semibold mb-2">LRN:</label>
                                            <div class="bg-gray-100 px-4 py-2 rounded font-semibold" id="foundLRN">123456789012</div>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700 font-semibold mb-2">GRADE LEVEL:</label>
                                            <div class="bg-gray-100 px-4 py-2 rounded font-semibold" id="foundGrade">Grade 11</div>
                                        </div>
                                        <div>
                                            <label class="block text-gray-700 font-semibold mb-2">SECTION:</label>
                                            <div class="bg-gray-100 px-4 py-2 rounded font-semibold" id="foundSection">STEM A</div>
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
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <label class="block text-gray-700 font-semibold mb-2">NAME:</label>
                                                <input type="text" id="updateName" class="w-full border-2 border-gray-300 rounded-lg px-4 py-2" value="KARL PITMLS">
                                            </div>
                                            <div>
                                                <label class="block text-gray-700 font-semibold mb-2">LRN:</label>
                                                <input type="text" id="updateLRN" class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 bg-gray-100" value="123456789012" readonly>
                                            </div>
                                            <div class="md:col-span-2">
                                                <label class="block text-gray-700 font-semibold mb-2">ADDRESS:</label>
                                                <textarea id="updateAddress" class="w-full border-2 border-gray-300 rounded-lg px-4 py-2" rows="2">123 Main Street, City, State</textarea>
                                            </div>
                                            <div>
                                                <label class="block text-gray-700 font-semibold mb-2">GUARDIAN:</label>
                                                <input type="text" id="updateGuardian" class="w-full border-2 border-gray-300 rounded-lg px-4 py-2" value="MARIA PITMLS">
                                            </div>
                                            <div>
                                                <label class="block text-gray-700 font-semibold mb-2">CONTACT:</label>
                                                <input type="text" id="updateContact" class="w-full border-2 border-gray-300 rounded-lg px-4 py-2" value="0912-345-6789">
                                            </div>
                                        </div>
                                        
                                        <div class="flex gap-2 justify-end">
                                            <button type="button" onclick="cancelUpdate()" class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-6 rounded-lg font-semibold">
                                                CANCEL
                                            </button>
                                            <button type="button" onclick="submitUpdate()" class="bg-green-600 hover:bg-green-700 text-white py-2 px-6 rounded-lg font-semibold">
                                                SUBMIT
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
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page loaded successfully');
            // Force Back to Enrollment button visibility
            const backButton = document.getElementById('backButton');
            if (backButton) {
                backButton.style.display = 'inline-flex';
                backButton.style.visibility = 'visible';
                backButton.style.opacity = '1';
                console.log('Back to Enrollment button set to visible');
            } else {
                console.error('Back to Enrollment button not found in DOM');
            }
        });

        function searchStudent() {
            console.log('Search button clicked! Input:', document.getElementById('searchInput').value);
            
            const searchInput = document.getElementById('searchInput');
            const searchResults = document.getElementById('searchResults');
            const foundSection = document.getElementById('foundSection');
            const notFoundSection = document.getElementById('notFoundSection');
            const updateForm = document.getElementById('updateForm');
            
            // Hide all sections
            if (searchResults) searchResults.style.display = 'none';
            if (foundSection) foundSection.style.display = 'none';
            if (notFoundSection) notFoundSection.style.display = 'none';
            if (updateForm) updateForm.style.display = 'none';
            
            if (!searchInput.value.trim()) {
                console.log('Empty search input');
                alert('Please enter a name or LRN to search.');
                return;
            }
            
            // Show search results container
            if (searchResults) {
                searchResults.style.display = 'block';
                console.log('Search results container visible');
            }
            
            // Simulate finding a student
            if (searchInput.value.toLowerCase().includes('karl') || searchInput.value.includes('123456789012')) {
                console.log('Student FOUND - showing found section');
                if (foundSection) {
                    foundSection.style.display = 'block';
                    document.getElementById('foundName').textContent = 'KARL PITMLS';
                    document.getElementById('foundLRN').textContent = '123456789012';
                    document.getElementById('foundGrade').textContent = 'Grade 11';
                    document.getElementById('foundSection').textContent = 'STEM A';
                }
            } else {
                console.log('Student NOT FOUND - showing not found section');
                if (notFoundSection) {
                    notFoundSection.style.display = 'block';
                    // Force Register as New Student button visibility
                    const registerButton = document.getElementById('registerButton');
                    if (registerButton) {
                        registerButton.style.display = 'inline-flex';
                        registerButton.style.visibility = 'visible';
                        registerButton.style.opacity = '1';
                        console.log('Register as New Student button set to visible');
                    } else {
                        console.error('Register as New Student button not found in DOM');
                    }
                }
            }
        }
        
        function showUpdateForm() {
            const updateForm = document.getElementById('updateForm');
            const foundSection = document.getElementById('foundSection');
            if (updateForm) updateForm.style.display = 'block';
            if (foundSection) foundSection.style.display = 'none';
            
            document.getElementById('updateName').value = document.getElementById('foundName').textContent;
            document.getElementById('updateLRN').value = document.getElementById('foundLRN').textContent;
        }
        
        function cancelUpdate() {
            const updateForm = document.getElementById('updateForm');
            const foundSection = document.getElementById('foundSection');
            if (updateForm) updateForm.style.display = 'none';
            if (foundSection) foundSection.style.display = 'block';
        }
        
        function submitUpdate() {
            const updatedName = document.getElementById('updateName').value;
            const updatedAddress = document.getElementById('updateAddress').value;
            const updatedGuardian = document.getElementById('updateGuardian').value;
            const updatedContact = document.getElementById('updateContact').value;
            
            alert('Student information updated successfully!');
            document.getElementById('foundName').textContent = updatedName;
            cancelUpdate();
        }
        
        function enrollStudent() {
            const studentName = document.getElementById('foundName').textContent;
            const studentLRN = document.getElementById('foundLRN').textContent;
            
            if (confirm(`Enroll ${studentName} (LRN: ${studentLRN}) for the current school year?`)) {
                alert('Student enrolled successfully!');
                window.location.href = "{{ route('enrollment') }}";
            }
        }
        
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchStudent();
            }
        });
    </script>
</x-app-layout>