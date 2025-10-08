<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Pending Transferee Applications') }}
            </h2>
            <div class="text-sm text-gray-600">
                Total: {{ $transferees->count() }} pending
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

                    @if($transferees->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                        <th class="py-3 px-6 text-left">Student Information</th>
                                        <th class="py-3 px-6 text-left">Previous School</th>
                                        <th class="py-3 px-6 text-left">Grade Level</th>
                                        <th class="py-3 px-6 text-left">Transfer Reason</th>
                                        <th class="py-3 px-6 text-center">Applied Date</th>
                                        <th class="py-3 px-6 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @foreach($transferees as $transferee)
                                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                                            <td class="py-3 px-6 text-left">
                                                <div class="font-medium text-gray-900">{{ $transferee->student->full_name }}</div>
                                                <div class="text-gray-500 text-xs mt-1">
                                                    LRN: {{ $transferee->student->lrn ?? 'N/A' }}
                                                </div>
                                                <div class="text-gray-500 text-xs">
                                                    {{ $transferee->student->email }}
                                                </div>
                                                <div class="text-gray-500 text-xs">
                                                    {{ $transferee->student->phone }}
                                                </div>
                                            </td>
                                            <td class="py-3 px-6 text-left">
                                                <div class="font-medium text-sm">{{ $transferee->previous_school }}</div>
                                                <div class="text-gray-500 text-xs mt-1">{{ Str::limit($transferee->previous_school_address, 40) }}</div>
                                                <span class="inline-block mt-1 bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                                    {{ ucfirst($transferee->school_type) }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-6 text-left">
                                                <div class="flex flex-col space-y-1">
                                                    <div class="text-xs">
                                                        <span class="font-semibold">From:</span> Grade {{ $transferee->previous_grade }}
                                                    </div>
                                                    <div class="text-xs font-semibold text-green-600">
                                                        <span class="font-semibold">To:</span> Grade {{ $transferee->desired_grade }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3 px-6 text-left">
                                                <div class="text-xs text-gray-700">{{ Str::limit($transferee->transfer_reason, 70) }}</div>
                                                @if($transferee->last_school_year)
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        SY: {{ $transferee->last_school_year }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                <div class="text-xs text-gray-500">
                                                    {{ $transferee->created_at->format('M d, Y') }}
                                                </div>
                                                <div class="text-xs text-gray-400">
                                                    {{ $transferee->created_at->format('g:i A') }}
                                                </div>
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                <div class="flex flex-col space-y-2">
                                                    <a href="{{ route('transferees.show', $transferee) }}" 
                                                       class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-3 rounded text-xs font-medium transition duration-200">
                                                        View Details
                                                    </a>
                                                    <div class="flex space-x-1">
                                                        <form action="{{ route('transferees.approve', $transferee) }}" method="POST" class="flex-1">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="w-full bg-green-500 hover:bg-green-600 text-white py-2 px-2 rounded text-xs font-medium transition duration-200"
                                                                    onclick="return confirm('Approve {{ $transferee->student->full_name }}\'s application?')">
                                                                Approve
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('transferees.reject', $transferee) }}" method="POST" class="flex-1">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="w-full bg-red-500 hover:bg-red-600 text-white py-2 px-2 rounded text-xs font-medium transition duration-200"
                                                                    onclick="return confirm('Reject {{ $transferee->student->full_name }}\'s application?')">
                                                                Reject
                                                            </button>
                                                        </form>
                                                    </div>
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
                            <h3 class="mt-4 text-lg font-medium text-gray-900">No pending transferee applications</h3>
                            <p class="mt-2 text-sm text-gray-500">All transferee applications have been processed.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>