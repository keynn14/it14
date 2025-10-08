<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Returnee Details') }}
            </h2>
            <a href="{{ route('principal.returnees.pending') }}" 
               class="text-sm bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-2 rounded transition">
                ← Back to Pending List
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-6">

                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">Student Information</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div><strong>Full Name:</strong> {{ $returnee->student->full_name }}</div>
                        <div><strong>LRN:</strong> {{ $returnee->student->lrn ?? 'N/A' }}</div>
                        <div><strong>Email:</strong> {{ $returnee->student->email }}</div>
                        <div><strong>Phone:</strong> {{ $returnee->student->phone ?? 'N/A' }}</div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">Academic Information</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div><strong>Previous Grade Level:</strong> Grade {{ $returnee->previous_grade_level }}</div>
                        <div><strong>New Grade Level:</strong> Grade {{ $returnee->new_grade_level }}</div>
                        <div><strong>Previous School Year:</strong> {{ $returnee->previous_school_year ?? 'N/A' }}</div>
                        <div><strong>Average Grade:</strong> 
                            {{ $returnee->academic_status['average_grade'] ?? 'Not Available' }}
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">Reason for Return</h3>
                    <p class="text-sm text-gray-800">{{ $returnee->reason_for_return }}</p>
                </div>

                <div class="flex justify-end space-x-2 mt-6">
                    <form action="{{ route('principal.returnees.approve', $returnee) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition"
                                onclick="return confirm('Approve this returnee application?')">
                            Approve
                        </button>
                    </form>

                    <form action="{{ route('principal.returnees.reject', $returnee) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition"
                                onclick="return confirm('Reject this returnee application?')">
                            Reject
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
