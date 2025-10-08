<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Transferee Details') }}
            </h2>
            <a href="{{ route('principal.transferees.pending') }}" 
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
                        <div><strong>Full Name:</strong> {{ $transferee->student->full_name }}</div>
                        <div><strong>LRN:</strong> {{ $transferee->student->lrn ?? 'N/A' }}</div>
                        <div><strong>Email:</strong> {{ $transferee->student->email }}</div>
                        <div><strong>Phone:</strong> {{ $transferee->student->phone ?? 'N/A' }}</div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">Previous School Information</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div><strong>School Name:</strong> {{ $transferee->previous_school }}</div>
                        <div><strong>School Type:</strong> {{ ucfirst($transferee->school_type) }}</div>
                        <div><strong>Address:</strong> {{ $transferee->previous_school_address }}</div>
                        <div><strong>Last School Year:</strong> {{ $transferee->last_school_year ?? 'N/A' }}</div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">Academic Information</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div><strong>Previous Grade:</strong> Grade {{ $transferee->previous_grade }}</div>
                        <div><strong>Desired Grade:</strong> Grade {{ $transferee->desired_grade }}</div>
                        <div class="col-span-2"><strong>Transfer Reason:</strong> {{ $transferee->transfer_reason }}</div>
                    </div>
                </div>

                <div class="flex justify-end space-x-2 mt-6">
                    <form action="{{ route('principal.transferees.approve', $transferee) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition"
                                onclick="return confirm('Approve this transferee application?')">
                            Approve
                        </button>
                    </form>

                    <form action="{{ route('principal.transferees.reject', $transferee) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition"
                                onclick="return confirm('Reject this transferee application?')">
                            Reject
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>