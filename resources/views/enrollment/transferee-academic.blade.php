<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Enroll Transferee/Returnee - Step 2: Academic Information') }}
            </h2>
            <a href="{{ route('transferee.info') }}" 
               class="bg-gray-600 text-white px-4 py-2 rounded-lg text-decoration-none inline-flex items-center gap-2 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Back to Student Info
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 bg-white border-b border-gray-200">
                    
                    <!-- Progress Steps -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white font-semibold">✓</div>
                                <span class="ml-2 text-green-600 font-medium">Student Information</span>
                            </div>
                            <div class="flex-1 h-1 bg-blue-600 mx-4"></div>
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">2</div>
                                <span class="ml-2 text-blue-600 font-medium">Academic Information</span>
                            </div>
                            <div class="flex-1 h-1 bg-gray-300 mx-4"></div>
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-semibold">3</div>
                                <span class="ml-2 text-gray-500">Documents</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- LRN Display -->
                    @if(session('lrn') || old('lrn'))
                    <div class="mb-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <h4 class="font-medium text-gray-900 mb-2">Learner Reference Number</h4>
                        <div class="flex items-center gap-4">
                            <span class="text-lg font-mono font-bold text-gray-700">{{ session('lrn') ?? old('lrn') }}</span>
                            <span class="text-sm text-gray-500">(This LRN will be used for your enrollment)</span>
                        </div>
                        <!-- Hidden field to preserve LRN -->
                        <input type="hidden" name="lrn" value="{{ session('lrn') ?? old('lrn') }}">
                    </div>
                    @endif
                    
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Academic Background</h3>
                    
                    <form action="{{ route('transferee.academic.process') }}" method="POST">
                        @csrf
                        
                        <!-- Hidden LRN field -->
                        <input type="hidden" name="lrn" value="{{ session('lrn') ?? old('lrn') }}">
                        
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Previous School <span class="text-red-600">*</span>
                            </label>
                            <input type="text" 
                                   name="previous_school" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Enter previous school name"
                                   value="{{ old('previous_school') }}"
                                   required>
                            @error('previous_school')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Previous School Address <span class="text-red-600">*</span>
                                </label>
                                <input type="text" 
                                       name="previous_school_address" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Enter school address"
                                       value="{{ old('previous_school_address') }}"
                                       required>
                                @error('previous_school_address')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Previous School Type <span class="text-red-600">*</span>
                                </label>
                                <select name="school_type" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                    <option value="">Select school type</option>
                                    <option value="public" {{ old('school_type') == 'public' ? 'selected' : '' }}>Public</option>
                                    <option value="private" {{ old('school_type') == 'private' ? 'selected' : '' }}>Private</option>
                                </select>
                                @error('school_type')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Previous Grade Level <span class="text-red-600">*</span>
                                </label>
                                <select name="previous_grade" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                    <option value="">Select grade level</option>
                                    <option value="7" {{ old('previous_grade') == '7' ? 'selected' : '' }}>Grade 7</option>
                                    <option value="8" {{ old('previous_grade') == '8' ? 'selected' : '' }}>Grade 8</option>
                                    <option value="9" {{ old('previous_grade') == '9' ? 'selected' : '' }}>Grade 9</option>
                                    <option value="10" {{ old('previous_grade') == '10' ? 'selected' : '' }}>Grade 10</option>
                                    <option value="11" {{ old('previous_grade') == '11' ? 'selected' : '' }}>Grade 11</option>
                                    <option value="12" {{ old('previous_grade') == '12' ? 'selected' : '' }}>Grade 12</option>
                                </select>
                                @error('previous_grade')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Desired Grade Level <span class="text-red-600">*</span>
                                </label>
                                <select name="desired_grade" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                    <option value="">Select grade level</option>
                                    <option value="7" {{ old('desired_grade') == '7' ? 'selected' : '' }}>Grade 7</option>
                                    <option value="8" {{ old('desired_grade') == '8' ? 'selected' : '' }}>Grade 8</option>
                                    <option value="9" {{ old('desired_grade') == '9' ? 'selected' : '' }}>Grade 9</option>
                                    <option value="10" {{ old('desired_grade') == '10' ? 'selected' : '' }}>Grade 10</option>
                                    <option value="11" {{ old('desired_grade') == '11' ? 'selected' : '' }}>Grade 11</option>
                                    <option value="12" {{ old('desired_grade') == '12' ? 'selected' : '' }}>Grade 12</option>
                                </select>
                                @error('desired_grade')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Last School Year Attended <span class="text-red-600">*</span>
                            </label>
                            <input type="text" 
                                   name="last_school_year" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="e.g., 2024-2025"
                                   value="{{ old('last_school_year') }}"
                                   required>
                            @error('last_school_year')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Reason for Transfer <span class="text-red-600">*</span>
                            </label>
                            <textarea name="transfer_reason" 
                                      rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Explain your reason for transferring"
                                      required>{{ old('transfer_reason') }}</textarea>
                            @error('transfer_reason')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between">
                            <a href="{{ route('transferee.info') }}" 
                               class="bg-gray-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-gray-600 transition duration-200">
                                ← Back
                            </a>
                            <button type="submit" 
                                    class="bg-blue-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-blue-700 transition duration-200">
                                Next: Documents →
                            </button>
                        </div>
                        
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>