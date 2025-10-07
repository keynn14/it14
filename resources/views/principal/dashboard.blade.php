<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Principal Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-4">Principal Dashboard</h2>
                    <p class="mb-6">Overview of pending enrollments.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-blue-100 p-6 rounded-lg border border-blue-200">
                            <p class="text-lg font-semibold text-blue-800">Pending for {{ $currentYear }}:</p>
                            <p class="text-4xl font-bold text-blue-900 mt-2">{{ $pendingCurrent }}</p>
                        </div>
                        <div class="bg-green-100 p-6 rounded-lg border border-green-200">
                            <p class="text-lg font-semibold text-green-800">Pending for {{ $upcomingYear }}:</p>
                            <p class="text-4xl font-bold text-green-900 mt-2">{{ $pendingUpcoming }}</p>
                        </div>
                    </div>
                    <a href="{{ route('principal.pending-students') }}" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">View Pending Students for Approval</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>