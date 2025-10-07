<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Returnee Enrollment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .status-passed { background-color: #d1fae5; color: #065f46; }
        .status-failed { background-color: #fee2e2; color: #991b1b; }
        .status-remediation { background-color: #fef3c7; color: #92400e; }
        .status-retained { background-color: #fecaca; color: #7f1d1d; }
        .status-promoted { background-color: #dcfce7; color: #166534; }
        .grade-input:invalid { border-color: #ef4444; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Student Enrollment System</h1>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('enrollment') }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Dashboard
                    </a>
                    <span class="text-gray-700">Admin User</span>
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Returnee Student Enrollment</h2>
                    <p class="text-gray-600 mt-1">Search for existing students by LRN to enroll them for the new school year</p>
                </div>

                <!-- Search Section -->
                <div class="p-6 border-b border-gray-200">
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Search Student by LRN (Learner Reference Number) <span class="text-red-600">*</span>
                        </label>
                        <div class="flex space-x-4">
                            <input type="text" 
                                   id="lrn-search" 
                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Enter 12-digit LRN">
                            <button id="search-btn" 
                                    class="bg-blue-600 text-white px-6 py-2 rounded-md font-medium hover:bg-blue-700 transition duration-200">
                                <i class="fas fa-search mr-2"></i> Search
                            </button>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Enter the student's LRN to retrieve their information and academic records</p>
                    </div>

                    <!-- Search Results -->
                    <div id="search-results" class="hidden mt-6">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                            <div class="flex items-center">
                                <div class="bg-blue-100 p-2 rounded-full mr-4">
                                    <i class="fas fa-user-graduate text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900" id="student-name">Juan Dela Cruz</h3>
                                    <div class="flex flex-wrap gap-4 mt-1 text-sm text-gray-600">
                                        <span><strong>LRN:</strong> <span id="student-lrn">123456789012</span></span>
                                        <span><strong>Grade Level:</strong> <span id="student-grade">Grade 8</span></span>
                                        <span><strong>Previous School Year:</strong> <span id="student-sy">2022-2023</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Academic Records Table -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Academic Records</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="grades-table-body" class="bg-white divide-y divide-gray-200">
                                        <!-- Grades will be populated here by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Promotion Status -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Promotion Status</h3>
                            <div id="promotion-status" class="p-4 rounded-lg">
                                <!-- Status will be populated here by JavaScript -->
                            </div>
                        </div>

                        <!-- Enrollment Actions -->
                        <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                            <button id="cancel-btn" class="bg-gray-500 text-white px-6 py-2 rounded-md font-medium hover:bg-gray-600 transition duration-200">
                                Cancel
                            </button>
                            <button id="enroll-btn" class="bg-green-600 text-white px-6 py-2 rounded-md font-medium hover:bg-green-700 transition duration-200">
                                <i class="fas fa-user-plus mr-2"></i> Enroll Student
                            </button>
                        </div>
                    </div>

                    <!-- No Results Message -->
                    <div id="no-results" class="hidden mt-6 p-6 bg-yellow-50 border border-yellow-200 rounded-lg text-center">
                        <i class="fas fa-exclamation-triangle text-yellow-500 text-2xl mb-3"></i>
                        <h3 class="font-medium text-gray-900">No Student Found</h3>
                        <p class="text-gray-600 mt-1">No student record found with the provided LRN.</p>
                        <p class="text-gray-600">Please check the LRN or consider enrolling as a transferee if the student is from another school.</p>
                        <a href="{{ route('transferee.info') }}" class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded-md font-medium hover:bg-blue-700 transition duration-200">
                            Enroll as Transferee
                        </a>
                    </div>
                </div>

                <!-- Manual Grade Entry (for testing/demo) -->
                <div class="p-6 bg-gray-50 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Manual Grade Entry (For Demo)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                            <input type="text" id="subject-input" class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="Subject name">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Grade</label>
                            <input type="number" id="grade-input" min="65" max="100" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-md grade-input" placeholder="0-100">
                        </div>
                    </div>
                    <button id="add-grade-btn" class="bg-blue-600 text-white px-4 py-2 rounded-md font-medium hover:bg-blue-700 transition duration-200">
                        Add Grade
                    </button>
                    <button id="clear-grades-btn" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded-md font-medium hover:bg-gray-600 transition duration-200">
                        Clear All Grades
                    </button>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Sample student data for demonstration
        const sampleStudents = {
            '123456789012': {
                name: 'Juan Dela Cruz',
                lrn: '123456789012',
                grade: 'Grade 8',
                schoolYear: '2022-2023',
                grades: [
                    { subject: 'Mathematics', grade: 85 },
                    { subject: 'Science', grade: 78 },
                    { subject: 'English', grade: 82 },
                    { subject: 'Filipino', grade: 80 },
                    { subject: 'Araling Panlipunan', grade: 79 },
                    { subject: 'MAPEH', grade: 88 },
                    { subject: 'EPP/TLE', grade: 85 },
                    { subject: 'ESP', grade: 90 }
                ]
            },
            '987654321098': {
                name: 'Maria Santos',
                lrn: '987654321098',
                grade: 'Grade 9',
                schoolYear: '2022-2023',
                grades: [
                    { subject: 'Mathematics', grade: 74 },
                    { subject: 'Science', grade: 82 },
                    { subject: 'English', grade: 85 },
                    { subject: 'Filipino', grade: 79 },
                    { subject: 'Araling Panlipunan', grade: 81 },
                    { subject: 'MAPEH', grade: 88 },
                    { subject: 'EPP/TLE', grade: 86 },
                    { subject: 'ESP', grade: 83 }
                ]
            },
            '456123789045': {
                name: 'Pedro Reyes',
                lrn: '456123789045',
                grade: 'Grade 10',
                schoolYear: '2022-2023',
                grades: [
                    { subject: 'Mathematics', grade: 72 },
                    { subject: 'Science', grade: 70 },
                    { subject: 'English', grade: 74 },
                    { subject: 'Filipino', grade: 78 },
                    { subject: 'Araling Panlipunan', grade: 75 },
                    { subject: 'MAPEH', grade: 80 },
                    { subject: 'EPP/TLE', grade: 82 },
                    { subject: 'ESP', grade: 79 }
                ]
            }
        };

        // DOM Elements
        const lrnSearch = document.getElementById('lrn-search');
        const searchBtn = document.getElementById('search-btn');
        const searchResults = document.getElementById('search-results');
        const noResults = document.getElementById('no-results');
        const studentName = document.getElementById('student-name');
        const studentLrn = document.getElementById('student-lrn');
        const studentGrade = document.getElementById('student-grade');
        const studentSy = document.getElementById('student-sy');
        const gradesTableBody = document.getElementById('grades-table-body');
        const promotionStatus = document.getElementById('promotion-status');
        const enrollBtn = document.getElementById('enroll-btn');
        const cancelBtn = document.getElementById('cancel-btn');
        const subjectInput = document.getElementById('subject-input');
        const gradeInput = document.getElementById('grade-input');
        const addGradeBtn = document.getElementById('add-grade-btn');
        const clearGradesBtn = document.getElementById('clear-grades-btn');

        // Current student data
        let currentStudent = null;
        let currentGrades = [];

        // Search for student
        searchBtn.addEventListener('click', function() {
            const lrn = lrnSearch.value.trim();
            
            if (lrn.length === 0) {
                alert('Please enter an LRN to search');
                return;
            }
            
            if (sampleStudents[lrn]) {
                currentStudent = sampleStudents[lrn];
                currentGrades = [...currentStudent.grades];
                displayStudentInfo();
                displayGrades();
                calculatePromotionStatus();
                searchResults.classList.remove('hidden');
                noResults.classList.add('hidden');
            } else {
                searchResults.classList.add('hidden');
                noResults.classList.remove('hidden');
            }
        });

        // Display student information
        function displayStudentInfo() {
            studentName.textContent = currentStudent.name;
            studentLrn.textContent = currentStudent.lrn;
            studentGrade.textContent = currentStudent.grade;
            studentSy.textContent = currentStudent.schoolYear;
        }

        // Display grades in table
        function displayGrades() {
            gradesTableBody.innerHTML = '';
            
            currentGrades.forEach(item => {
                const status = getGradeStatus(item.grade);
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${item.subject}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${item.grade}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full status-${status}">
                            ${status.charAt(0).toUpperCase() + status.slice(1)}
                        </span>
                    </td>
                `;
                gradesTableBody.appendChild(row);
            });
        }

        // Calculate grade status
        function getGradeStatus(grade) {
            if (grade >= 75) {
                return 'passed';
            } else {
                return 'failed';
            }
        }

        // Calculate promotion status
        function calculatePromotionStatus() {
            const failedSubjects = currentGrades.filter(item => item.grade < 75);
            const failedCount = failedSubjects.length;
            
            let status, message, statusClass;
            
            if (failedCount === 0) {
                status = 'promoted';
                message = 'Student is eligible for promotion to the next grade level.';
                statusClass = 'status-promoted';
            } else if (failedCount === 1) {
                status = 'remediation';
                message = 'Student requires remediation in one subject but is eligible for promotion.';
                statusClass = 'status-remediation';
            } else if (failedCount <= 3) {
                status = 'remediation';
                message = `Student requires remediation in ${failedCount} subjects but is eligible for promotion.`;
                statusClass = 'status-remediation';
            } else {
                status = 'retained';
                message = `Student has failed ${failedCount} subjects and must repeat the grade level.`;
                statusClass = 'status-retained';
            }
            
            promotionStatus.innerHTML = `
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas ${status === 'promoted' ? 'fa-check-circle' : status === 'remediation' ? 'fa-exclamation-triangle' : 'fa-times-circle'} text-xl ${status === 'promoted' ? 'text-green-500' : status === 'remediation' ? 'text-yellow-500' : 'text-red-500'}"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-lg font-medium ${status === 'promoted' ? 'text-green-800' : status === 'remediation' ? 'text-yellow-800' : 'text-red-800'}">
                            ${status.charAt(0).toUpperCase() + status.slice(1)}
                        </h4>
                        <p class="mt-1 ${status === 'promoted' ? 'text-green-700' : status === 'remediation' ? 'text-yellow-700' : 'text-red-700'}">
                            ${message}
                        </p>
                    </div>
                </div>
            `;
            promotionStatus.className = `p-4 rounded-lg ${statusClass}`;
        }

        // Add grade manually (for demo)
        addGradeBtn.addEventListener('click', function() {
            const subject = subjectInput.value.trim();
            const grade = parseFloat(gradeInput.value);
            
            if (!subject || isNaN(grade)) {
                alert('Please enter both subject and grade');
                return;
            }
            
            if (grade < 65 || grade > 100) {
                alert('Grade must be between 65 and 100');
                return;
            }
            
            currentGrades.push({ subject, grade });
            displayGrades();
            calculatePromotionStatus();
            
            // Clear inputs
            subjectInput.value = '';
            gradeInput.value = '';
        });

        // Clear all grades (for demo)
        clearGradesBtn.addEventListener('click', function() {
            if (confirm('Are you sure you want to clear all grades?')) {
                currentGrades = [];
                displayGrades();
                calculatePromotionStatus();
            }
        });

        // Cancel enrollment
        cancelBtn.addEventListener('click', function() {
            if (confirm('Are you sure you want to cancel? All changes will be lost.')) {
                searchResults.classList.add('hidden');
                lrnSearch.value = '';
                currentStudent = null;
                currentGrades = [];
            }
        });

        // Enroll student
        enrollBtn.addEventListener('click', function() {
            // In a real application, this would submit the enrollment data to the server
            alert('Student enrollment submitted successfully!');
            // Redirect or reset form
            searchResults.classList.add('hidden');
            lrnSearch.value = '';
            currentStudent = null;
            currentGrades = [];
        });

        // Allow pressing Enter to search
        lrnSearch.addEventListener('keyup', function(event) {
            if (event.key === 'Enter') {
                searchBtn.click();
            }
        });
    </script>
</body>
</html>