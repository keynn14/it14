<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learner Information Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black-100 p-4">
    <div class="max-w-5xl mx-auto">
        <div class="p-6 border-2 border-green-500 rounded-lg bg-green-50">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center font-bold mr-3">1</div>
                <h3 class="text-2xl font-bold text-black-800">LEARNER INFORMATION</h3>
            </div>
            <div class="bg-white p-6 rounded-lg border border-green-300">
                <!-- PSA Birth Certificate -->
                <div class="mb-6">
                    <label class="block text-black-700 font-semibold mb-2">PSA Birth Certificate No. (if available upon registration)</label>
                    <input type="text" name="psa_birth_certificate" class="w-full border-2 border-black-300 rounded-lg px-4 py-3 focus:outline-none focus:border-green-500" placeholder="Enter PSA Birth Certificate No.">
                </div>

                <!-- Name Section - 2 columns -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-black-700 font-semibold mb-2">Last Name</label>
                            <input type="text" name="last_name" class="w-full border-2 border-black-300 rounded-lg px-4 py-3 focus:outline-none focus:border-green-500" placeholder="Enter Last Name" required>
                        </div>
                        <div>
                            <label class="block text-black-700 font-semibold mb-2">First Name</label>
                            <input type="text" name="first_name" class="w-full border-2 border-black-300 rounded-lg px-4 py-3 focus:outline-none focus:border-green-500" placeholder="Enter First Name" required>
                        </div>
                        <div>
                            <label class="block text-black-700 font-semibold mb-2">Middle Name</label>
                            <input type="text" name="middle_name" class="w-full border-2 border-black-300 rounded-lg px-4 py-3 focus:outline-none focus:border-green-500" placeholder="Enter Middle Name">
                        </div>
                        <div>
                            <label class="block text-black-700 font-semibold mb-2">Extension Name e.g. Jr., (if applicable)</label>
                            <input type="text" name="extension_name" class="w-full border-2 border-black-300 rounded-lg px-4 py-3 focus:outline-none focus:border-green-500" placeholder="e.g. Jr., III">
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-black-700 font-semibold mb-2">Learner Reference No. (LRN)</label>
                            <input type="text" name="lrn" class="w-full border-2 border-black-300 rounded-lg px-4 py-3 focus:outline-none focus:border-green-500" placeholder="Enter LRN">
                        </div>
                        <div>
                            <label class="block text-black-700 font-semibold mb-2">Birthdate (mm/dd/yyyy)</label>
                            <input type="date" name="birthdate" class="w-full border-2 border-black-300 rounded-lg px-4 py-3 focus:outline-none focus:border-green-500" required>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-black-700 font-semibold mb-2">Sex</label>
                                <select name="sex" class="w-full border-2 border-black-300 rounded-lg px-4 py-3 focus:outline-none focus:border-green-500" required>
                                    <option value="">Select Sex</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-black-700 font-semibold mb-2">Age</label>
                                <input type="number" name="age" min="0" max="120" class="w-full border-2 border-black-300 rounded-lg px-4 py-3 focus:outline-none focus:border-green-500" placeholder="Enter Age">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Indigenous People Question -->
                <div class="mb-6">
                    <label class="block text-black-700 font-semibold mb-2">Belonging to any Indigenous People (IP) Community/Indigenous Cultural Community?</label>
                    <div class="flex items-center space-x-4 mb-2">
                        <label class="flex items-center">
                            <input type="radio" name="ip_community" value="yes" class="mr-2" onchange="toggleIPField(this)">
                            <span>Yes</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="ip_community" value="no" class="mr-2" onchange="toggleIPField(this)" checked>
                            <span>No</span>
                        </label>
                        <div id="ipField" class="hidden flex-1 ml-4">
                            <label class="block text-black-700 font-semibold mb-2">If Yes, please specify</label>
                            <input type="text" name="ip_specify" class="w-full border-2 border-black-300 rounded-lg px-4 py-3 focus:outline-none focus:border-green-500" placeholder="Specify IP Community">
                        </div>
                    </div>
                </div>

                <!-- 4Ps Question -->
                <div class="mb-6">
                    <label class="block text-black-700 font-semibold mb-2">Is your family a beneficiary of 4Ps?</label>
                    <div class="flex items-center space-x-4 mb-2">
                        <label class="flex items-center">
                            <input type="radio" name="4ps_beneficiary" value="yes" class="mr-2" onchange="toggle4PsField(this)">
                            <span>Yes</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="4ps_beneficiary" value="no" class="mr-2" onchange="toggle4PsField(this)" checked>
                            <span>No</span>
                        </label>
                        <div id="4psField" class="hidden flex-1 ml-4">
                            <label class="block text-black-700 font-semibold mb-2">If Yes, write the 4Ps Household ID Number</label>
                            <input type="text" name="4ps_household_id" class="w-full border-2 border-black-300 rounded-lg px-4 py-3 focus:outline-none focus:border-green-500" placeholder="Enter 4Ps Household ID Number">
                        </div>
                    </div>
                </div>

                <!-- Mother Tongue -->
                <div class="mb-6">
                    <label class="block text-black-700 font-semibold mb-2">Mother Tongue</label>
                    <input type="text" name="mother_tongue" class="w-full border-2 border-black-300 rounded-lg px-4 py-3 focus:outline-none focus:border-green-500" placeholder="Enter Mother Tongue">
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggle4PsField(radio) {
            const field = document.getElementById('4psField');
            if (radio.value === 'yes') {
                field.classList.remove('hidden');
            } else {
                field.classList.add('hidden');
                document.querySelector('input[name="4ps_household_id"]').value = '';
            }
        }

        function toggleIPField(radio) {
            const field = document.getElementById('ipField');
            if (radio.value === 'yes') {
                field.classList.remove('hidden');
            } else {
                field.classList.add('hidden');
                document.querySelector('input[name="ip_specify"]').value = '';
            }
        }

        function goBackToEnrollment() {
            // Replace with your actual enrollment page URL
            alert('Going back to enrollment page...');
            // window.location.href = 'enrollment.html';
        }

        function goToNextSection() {
            // Add validation if needed
            alert('Proceeding to next section...');
            // window.location.href = 'next-section.html';
        }
    </script>
</body>
</html>