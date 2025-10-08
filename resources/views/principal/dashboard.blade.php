<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Principal Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg p-6 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Students</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['total_students'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-6 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Active Enrollments</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['active_enrollments'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-6 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Pending Approvals</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['pending_enrollments'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-6 border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Pending Transferees</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['pending_transferees'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Approvals Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Pending by School Year -->
                <div class="bg-white rounded-lg p-6 border border-gray-200 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pending Approvals by School Year</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <p class="text-sm font-semibold text-blue-800">Pending for {{ $currentSchoolYear }}:</p>
                            <p class="text-3xl font-bold text-blue-900 mt-2">{{ $pendingCurrent }}</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                            <p class="text-sm font-semibold text-green-800">Pending for {{ $upcomingYear }}-{{ $upcomingYear + 1 }}:</p>
                            <p class="text-3xl font-bold text-green-900 mt-2">{{ $pendingUpcoming }}</p>
                        </div>
                    </div>
                    <div class="mt-4 flex space-x-3">
                        <a href="{{ route('principal.pending-students') }}" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition text-sm">
                            View All Pending Students
                        </a>
                        <a href="{{ route('principal.pending-transferees') }}" class="bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition text-sm">
                            View Pending Transferees
                        </a>
                    </div>
                </div>

                <!-- Recent Pending Enrollments -->
                <div class="bg-white rounded-lg p-6 border border-gray-200 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Pending Enrollments</h3>
                    @if($recentPending->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentPending as $enrollment)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $enrollment->student->full_name }}</p>
                                            <p class="text-xs text-gray-500">Grade {{ $enrollment->grade_level }} • {{ $enrollment->enrollment_type }}</p>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $enrollment->created_at->diffForHumans() }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-gray-500">
                            No pending enrollments
                        </div>
                    @endif
                </div>
            </div>

            <!-- Enrollment Statistics by Year -->
            <div class="bg-white rounded-lg p-6 border border-gray-200 shadow-sm mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Enrollment Statistics by School Year</h3>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase">School Year</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Total</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Approved</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Pending</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Transferees</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Returnees</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($enrollmentStats as $year => $stats)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $year }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $stats['total'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $stats['approved'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $stats['pending'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $stats['transferees'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $stats['returnees'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('principal.pending-students') }}" class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm hover:border-blue-500 hover:shadow-md transition">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Student Approvals</h3>
                            <p class="text-sm text-gray-600">Manage pending enrollments</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('principal.student-reports') }}" class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm hover:border-green-500 hover:shadow-md transition">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Student Reports</h3>
                            <p class="text-sm text-gray-600">View student statistics</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('principal.enrollment-reports') }}" class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm hover:border-purple-500 hover:shadow-md transition">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Enrollment Reports</h3>
                            <p class="text-sm text-gray-600">View enrollment analytics</p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>