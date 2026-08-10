<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reports Awaiting Your Review
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($logEntries->isEmpty())
                    <p class="text-gray-500">No reports are currently awaiting your review.</p>
                @else
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b">
                                <th class="pb-2">Date</th>
                                <th class="pb-2">Student</th>
                                <th class="pb-2">Operations Carried Out</th>
                                <th class="pb-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logEntries as $entry)
                                <tr class="border-b">
                                    <td class="py-3">{{ $entry->date }}</td>
                                    <td class="py-3">{{ $entry->internship->student->name }}</td>
                                    <td class="py-3">{{ Str::limit($entry->operations_carried_out, 50) }}</td>
                                    <td class="py-3">
                                        <a href="{{ route('reviews.show', $entry->id) }}"
                                           class="px-3 py-1 border border-blue-600 text-blue-600 rounded hover:bg-blue-600 hover:text-white transition-colors">
                                            Review
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>