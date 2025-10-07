<div class="p-6 border-2 border-green-500 rounded-lg bg-green-50">
    <div class="flex items-center mb-4">
        <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center font-bold mr-3">4</div>
        <h3 class="text-2xl font-bold text-black-800">PART 4: DISABILITY INFO</h3>
    </div>
    <div class="bg-white p-6 rounded-lg border border-green-300">
        <h4 class="text-xl font-semibold text-black-700 mb-6 text-center">SPECIAL NEEDS INFORMATION</h4>
        <div class="space-y-4">
            <div>
                <label class="block text-black-700 font-semibold mb-2">Disability Type</label>
                <select name="disability_type" class="w-full border-2 border-black-300 rounded-lg px-4 py-3 focus:outline-none focus:border-green-500">
                    <option value="none">No Disability</option>
                    <option value="physical">Physical Disability</option>
                    <option value="learning">Learning Disability</option>
                    <option value="visual">Visual Impairment</option>
                    <option value="hearing">Hearing Impairment</option>
                    <option value="speech">Speech Impairment</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div>
                <label class="block text-black-700 font-semibold mb-2">Special Requirements</label>
                <textarea name="special_requirements" class="w-full border-2 border-black-300 rounded-lg px-4 py-3 focus:outline-none focus:border-green-500" rows="3" placeholder="Describe any special accommodations needed..."></textarea>
            </div>
            <div>
                <label class="block text-black-700 font-semibold mb-2">Medical Conditions</label>
                <textarea name="medical_conditions" class="w-full border-2 border-black-300 rounded-lg px-4 py-3 focus:outline-none focus:border-green-500" rows="2" placeholder="List any medical conditions..."></textarea>
            </div>
        </div>
    </div>
</div>