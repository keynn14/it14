<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Enroll Transferee/Returnee - Step 3: Document Upload') }}
            </h2>
            <a href="{{ route('transferee.academic') }}" 
               class="bg-gray-600 text-white px-4 py-2 rounded-lg text-decoration-none inline-flex items-center gap-2 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Back to Academic Info
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
                            <div class="flex-1 h-1 bg-green-500 mx-4"></div>
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white font-semibold">✓</div>
                                <span class="ml-2 text-green-600 font-medium">Academic Information</span>
                            </div>
                            <div class="flex-1 h-1 bg-blue-600 mx-4"></div>
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">3</div>
                                <span class="ml-2 text-blue-600 font-medium">Documents</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- LRN Display -->
                    @if(session('lrn'))
                    <div class="mb-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <h4 class="font-medium text-gray-900 mb-2">Learner Reference Number</h4>
                        <div class="flex items-center gap-4">
                            <span class="text-lg font-mono font-bold text-gray-700">{{ session('lrn') }}</span>
                            <span class="text-sm text-gray-500">(Your registered LRN)</span>
                        </div>
                        <!-- Hidden field to preserve LRN -->
                        <input type="hidden" name="lrn" value="{{ session('lrn') }}">
                    </div>
                    @endif
                    
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Required Documents</h3>
                    
                    <form action="{{ route('transferee.submit') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Hidden LRN field -->
                        <input type="hidden" name="lrn" value="{{ session('lrn') }}">
                        
                        <div class="space-y-6 mb-8">
                            <div class="border border-gray-200 rounded-lg p-6">
                                <h4 class="font-medium text-gray-900 mb-3">Form 137 (Student Permanent Record) <span class="text-red-600">*</span></h4>
                                <p class="text-sm text-gray-600 mb-4">Official transcript from previous school</p>
                                <input type="file" 
                                       name="form_137" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                       accept=".pdf,.jpg,.jpeg,.png"
                                       required>
                                @error('form_137')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-sm text-gray-500 mt-2">Accepted formats: PDF, JPG, PNG (Max: 5MB)</p>
                            </div>
                            
                            <div class="border border-gray-200 rounded-lg p-6">
                                <h4 class="font-medium text-gray-900 mb-3">Good Moral Certificate <span class="text-red-600">*</span></h4>
                                <p class="text-sm text-gray-600 mb-4">Certificate of good moral character from previous school</p>
                                <input type="file" 
                                       name="good_moral" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                       accept=".pdf,.jpg,.jpeg,.png"
                                       required>
                                @error('good_moral')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-sm text-gray-500 mt-2">Accepted formats: PDF, JPG, PNG (Max: 5MB)</p>
                            </div>
                            
                            <div class="border border-gray-200 rounded-lg p-6">
                                <h4 class="font-medium text-gray-900 mb-3">Birth Certificate (Optional)</h4>
                                <p class="text-sm text-gray-600 mb-4">PSA/NSO birth certificate</p>
                                <input type="file" 
                                       name="birth_certificate" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                       accept=".pdf,.jpg,.jpeg,.png">
                                @error('birth_certificate')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-sm text-gray-500 mt-2">Accepted formats: PDF, JPG, PNG (Max: 5MB)</p>
                            </div>
                        </div>
                        
                        <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between">
                            <a href="{{ route('transferee.academic') }}" 
                               class="bg-gray-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-gray-600 transition duration-200">
                                ← Back
                            </a>
                            <button type="submit" 
                                    class="bg-green-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-green-700 transition duration-200">
                                Submit Enrollment
                            </button>
                        </div>
                        
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>