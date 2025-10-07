<div class="p-6 border-2 border-green-500 rounded-lg bg-green-50">
    <div class="flex items-center mb-4">
        <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center font-bold mr-3">5</div>
        <h3 class="text-2xl font-bold text-black-800">STUDENT PROFILE</h3>
    </div>
    <div class="bg-white p-6 rounded-lg border border-green-300">
        <h4 class="text-xl font-semibold text-black-700 mb-6 text-center">ACADEMIC INFORMATION</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-black-700 font-semibold mb-2">Grade Level *</label>
                <select name="grade_level" class="w-full border-2 border-black-300 rounded-lg px-4 py-3 focus:outline-none focus:border-green-500" required>
                    <option value="">Select Grade</option>
                    <option value="7">Grade 7</option>
                    <option value="8">Grade 8</option>
                    <option value="9">Grade 9</option>
                    <option value="10">Grade 10</option>
                    <option value="11">Grade 11</option>
                    <option value="12">Grade 12</option>
                </select>
            </div>
            <div>
                <label class="block text-black-700 font-semibold mb-2">Section/Class</label>
                <input type="text" name="section" class="w-full border-2 border-black-300 rounded-lg px-4 py-3 focus:outline-none focus:border-green-500">
            </div>
            <div>
                <label class="block text-black-700 font-semibold mb-2">Email Address</label>
                <input type="email" name="email" class="w-full border-2 border-black-300 rounded-lg px-4 py-3 focus:outline-none focus:border-green-500">
            </div>
            <div>
                <label class="block text-black-700 font-semibold mb-2">Phone Number</label>
                <input type="tel" name="phone" class="w-full border-2 border-black-300 rounded-lg px-4 py-3 focus:outline-none focus:border-green-500">
            </div>
        </div>
    </div>
</div>