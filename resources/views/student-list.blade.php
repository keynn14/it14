<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student List') }}
        </h2>
    </x-slot>

    <style>
        /* Force visibility of all buttons */
        .action-btn, .search-btn, .add-btn {
            display: inline-flex !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        .edit-btn {
            background-color: #16a34a !important;
            border: 2px solid #15803d !important;
            color: white !important;
        }
        
        .edit-btn:hover {
            background-color: #15803d !important;
        }
        
        .delete-btn {
            background-color: #dc2626 !important;
            border: 2px solid #b91c1c !important;
            color: white !important;
        }
        
        .delete-btn:hover {
            background-color: #b91c1c !important;
        }
        
        .search-btn {
            background-color: #16a34a !important;
            border: 2px solid #15803d !important;
            color: white !important;
        }
        
        .search-btn:hover {
            background-color: #15803d !important;
        }
        

    </style>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-6">
                
                <!-- Header Section -->
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Student Directory</h1>
                    <p class="text-gray-600 text-sm mt-1">Efficiently manage student records</p>
                </div>

                <!-- Search Section -->
                <div class="mb-8">
                    <div class="flex gap-3">
                        <input 
                            type="text" 
                            placeholder="Search by name or ID..." 
                            class="border-2 border-gray-300 rounded-lg px-4 py-2.5 flex-1 focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:outline-none" 
                            id="searchInput"
                        >
                        <a 
                            href="#"
                            id="searchButton"
                            class="search-btn action-btn px-6 py-2.5 rounded-lg transition duration-300 whitespace-nowrap inline-flex items-center justify-center font-medium"
                        >
                            <i class="fas fa-search mr-2"></i>Search
                        </a>
                    </div>
                </div>
                
                <!-- Table Section -->
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead class="bg-gray-50 text-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wide border-b-2 border-gray-200">Student ID</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wide border-b-2 border-gray-200">Name</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wide border-b-2 border-gray-200">Grade</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wide border-b-2 border-gray-200">Contact</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wide border-b-2 border-gray-200">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <!-- Student 1 -->
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">2024-001</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">KARL PITMLS</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">Grade 11</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">0912-345-6789</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <a href="#" class="edit-btn action-btn px-3 py-1.5 rounded hover:bg-green-700 transition duration-300 inline-flex items-center text-sm font-medium mr-2">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    <a href="#" class="delete-btn action-btn px-3 py-1.5 rounded hover:bg-red-700 transition duration-300 inline-flex items-center text-sm font-medium">
                                        <i class="fas fa-trash mr-1"></i>Delete
                                    </a>
                                </td>
                            </tr>
                            <!-- Student 2 -->
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">2024-002</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">MARIA SANTOS</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">Grade 10</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">0917-123-4567</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <a href="#" class="edit-btn action-btn px-3 py-1.5 rounded hover:bg-green-700 transition duration-300 inline-flex items-center text-sm font-medium mr-2">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    <a href="#" class="delete-btn action-btn px-3 py-1.5 rounded hover:bg-red-700 transition duration-300 inline-flex items-center text-sm font-medium">
                                        <i class="fas fa-trash mr-1"></i>Delete
                                    </a>
                                </td>
                            </tr>
                            <!-- Student 3 -->
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">2024-003</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">JUAN DELA CRUZ</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">Grade 12</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">0918-987-6543</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <a href="#" class="edit-btn action-btn px-3 py-1.5 rounded hover:bg-green-700 transition duration-300 inline-flex items-center text-sm font-medium mr-2">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    <a href="#" class="delete-btn action-btn px-3 py-1.5 rounded hover:bg-red-700 transition duration-300 inline-flex items-center text-sm font-medium">
                                        <i class="fas fa-trash mr-1"></i>Delete
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js"></script>
</x-app-layout>