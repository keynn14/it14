<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Courses') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Courses</h1>
                            <p class="text-gray-600">Manage all available courses</p>
                        </div>
                        <button class="bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700">
                            <i class="fas fa-plus mr-2"></i>Add Course
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white border rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-2">Mathematics</h3>
                            <p class="text-gray-600 mb-4">Advanced Mathematics Course</p>
                            <div class="flex justify-between text-sm text-gray-500">
                                <span>45 Students</span>
                                <span>Grade 11-12</span>
                            </div>
                        </div>
                        
                        <div class="bg-white border rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-2">Science</h3>
                            <p class="text-gray-600 mb-4">General Science Program</p>
                            <div class="flex justify-between text-sm text-gray-500">
                                <span>38 Students</span>
                                <span>Grade 10-12</span>
                            </div>
                        </div>
                        
                        <div class="bg-white border rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-2">English</h3>
                            <p class="text-gray-600 mb-4">Language and Literature</p>
                            <div class="flex justify-between text-sm text-gray-500">
                                <span>52 Students</span>
                                <span>All Grades</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</x-app-layout>