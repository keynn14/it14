<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Pending Returnee Applications') }}
            </h2>
            <div class="text-sm text-gray-600">
                Total: {{ $returnees->count() }} pending
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($returnees->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                        <th class="py-3 px-6 text-left">Student Information</th>
                                        <th class="py-3 px-6 text-left">Academic Progress</th>
                                        <th class="py-3 px-6 text-left">Reason for Return</th>
                                        <th class="py-3 px-6 text-center">Promotion Status</th>
                                        <th class="py-3 px-6 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @foreach($returnees as $returnee)
                                        @php
                                            $promotionStatus = $returnee->academic_status ?: $returnee->calculatePromotionStatus();
                                        @endphp
                                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                                            <td class="py-3 px-6 text-left">
                                                <div class="font-medium text-gray-900">{{ $returnee->student->full_name }}</div>
                                                <div class="text-gray-500 text-xs mt-1">
                                                    LRN: {{ $returnee->student->lrn ?? 'N/A' }}
                                                </div>
                                                <div class="text-gray-500 text-xs">
                                                    {{ $returnee->student->email }}
                                                </div>
                                            </td>
                                            <td class="py-3 px-6 text-left">
                                                <div class="text-xs space-y-1">
                                                    <div>
                                                        <span class="font-semibold">Last Attended:</span> Grade {{ $returnee->previous_grade_level }}
                                                    </div>
                                                    <div class="text-green-600 font-semibold">
                                                        <span class="font-semibold">Returning to:</span> Grade {{ $returnee->new_grade_level }}
                                                    </div>
                                                    <div class="text-gray-500">
                                                        School Year: {{ $returnee->previous_school_year }}
                                                    </div>
                                                    @if($promotionStatus && isset($promotionStatus['average_grade']))
                                                        <div class="text-blue-600 font-medium">
                                                            Average: {{ number_format($promotionStatus['average_grade'], 2) }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="py-3 px-6 text-left">
                                                <div class="text-xs text-gray-700">{{ Str::limit($returnee->reason_for_return, 80) }}</div>
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                @if($promotionStatus)
                                                    @if($promotionStatus['can_proceed'])
                                                        <span class="inline-block bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-medium">
                                                            ✅ Eligible
                                                        </span>
                                                        <div class="text-xs text-green-600 mt-1">
                                                            Ready to proceed
                                                        </div>
                                                    @else
                                                        <span class="inline-block bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full font-medium">
                                                            ⚠️ Review Needed
                                                        </span>
                                                        <div class="text-xs text-red-600 mt-1">
                                                            {{ $promotionStatus['failed_count'] }} failed subject(s)
                                                        </div>
                                                    @endif
                                                @else
                                                    <span class="inline-block bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full">
                                                        Calculating...
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                <div class="flex flex-col space-y-2">
                                                    <a href="{{ route('returnees.show', $returnee) }}" 
                                                       class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-3 rounded text-xs font-medium transition duration-200">
                                                        View Details
                                                    </a>
                                                    <form action="{{ route('returnees.approve', $returnee) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="w-full bg-green-500 hover:bg-green-600 text-white py-2 px-3 rounded text-xs font-medium transition duration-200"
                                                                onclick="return confirm('Approve {{ $returnee->student->full_name }}\'s returnee application?')">
                                                            Approve
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">No pending returnee applications</h3>
                            <p class="mt-2 text-sm text-gray-500">All returnee applications have been processed.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>