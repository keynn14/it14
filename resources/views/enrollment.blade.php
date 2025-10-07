<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-800 leading-tight">
            {{ __('Enrollment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 sm:p-8">
                    
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-3">Student Enrollment</h2>
                        <p class="text-gray-600">Select the appropriate enrollment option</p>
                    </div>

                    <div class="max-w-2xl mx-auto space-y-4">
                        
                        <!-- Old Student Button -->
                        <a href="{{ route('enrollment.old-student') }}" 
                           class="group flex items-center justify-between p-6 bg-gradient-to-r from-blue-50 to-blue-100 border-2 border-blue-200 rounded-xl hover:border-blue-400 hover:shadow-lg transition-all duration-300">
                            <div class="flex items-center gap-4">
                                <div class="flex items-center justify-center w-14 h-14 bg-blue-500 rounded-full group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">Enroll Old Student</h3>
                                    <p class="text-sm text-gray-600">For returning students</p>
                                </div>
                            </div>
                            <svg class="w-6 h-6 text-blue-500 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>

                        <!-- Returnee Student Button -->
                        <a href="{{ route('enrollment.returnee') }}" 
                           class="group flex items-center justify-between p-6 bg-gradient-to-r from-indigo-50 to-indigo-100 border-2 border-indigo-200 rounded-xl hover:border-indigo-400 hover:shadow-lg transition-all duration-300">
                            <div class="flex items-center gap-4">
                                <div class="flex items-center justify-center w-14 h-14 bg-indigo-500 rounded-full group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">Enroll Returnee</h3>
                                    <p class="text-sm text-gray-600">For students with academic records</p>
                                </div>
                            </div>
                            <svg class="w-6 h-6 text-indigo-500 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>

                        <!-- Transferee Button -->
                        <a href="{{ route('transferee.info') }}" 
                           class="group flex items-center justify-between p-6 bg-gradient-to-r from-purple-50 to-purple-100 border-2 border-purple-200 rounded-xl hover:border-purple-400 hover:shadow-lg transition-all duration-300">
                            <div class="flex items-center gap-4">
                                <div class="flex items-center justify-center w-14 h-14 bg-purple-500 rounded-full group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-purple-600 transition-colors">Enroll Transferee</h3>
                                    <p class="text-sm text-gray-600">For students from other schools</p>
                                </div>
                            </div>
                            <svg class="w-6 h-6 text-purple-500 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>

                        <!-- New Student Button -->
                        <a href="{{ route('enrollment.new-student') }}" 
                           class="group flex items-center justify-between p-6 bg-gradient-to-r from-green-50 to-green-100 border-2 border-green-200 rounded-xl hover:border-green-400 hover:shadow-lg transition-all duration-300">
                            <div class="flex items-center gap-4">
                                <div class="flex items-center justify-center w-14 h-14 bg-green-500 rounded-full group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-green-600 transition-colors">Register New Student</h3>
                                    <p class="text-sm text-gray-600">For first-time enrollees</p>
                                </div>
                            </div>
                            <svg class="w-6 h-6 text-green-500 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>

                    </div>

                    <!-- Info Section -->
                    <div class="mt-12 max-w-2xl mx-auto bg-gray-50 rounded-lg p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Enrollment Types</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm text-gray-600">
                            <div class="text-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <h4 class="font-medium text-gray-900">Old Student</h4>
                                <p>Returning students from previous years</p>
                            </div>
                            <div class="text-center">
                                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h4 class="font-medium text-gray-900">Returnee</h4>
                                <p>Students with academic records review</p>
                            </div>
                            <div class="text-center">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                    </svg>
                                </div>
                                <h4 class="font-medium text-gray-900">Transferee</h4>
                                <p>Students transferring from other schools</p>
                            </div>
                            <div class="text-center">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </div>
                                <h4 class="font-medium text-gray-900">New Student</h4>
                                <p>First-time students with no previous records</p>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>