<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Review Report
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if ($logEntry->flagged_duplicate)
                <div class="mb-4 p-4 bg-yellow-100 text-yellow-800 rounded">
                    ⚠ This report is similar to a previous entry{{ $logEntry->similarEntry ? ' dated ' . $logEntry->similarEntry->date : '' }}. Please review carefully before approving.
                </div>
             @endif
             @php
            $weekStart = \App\Models\WeeklyDiagram::currentWeekStart();
            $weeklyDiagram = \App\Models\WeeklyDiagram::where('internship_id', $logEntry->internship_id)
                ->where('week_start_date', \Carbon\Carbon::parse($logEntry->date)->startOfWeek(\Carbon\Carbon::MONDAY))
                ->first();
        @endphp

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">This Week's Diagram</h3>
            @if ($weeklyDiagram)
                <p class="text-gray-600 mb-2">{{ $weeklyDiagram->original_filename }} — uploaded {{ $weeklyDiagram->uploaded_at->format('d M Y, H:i') }}</p>
                @if (Str::endsWith($weeklyDiagram->file_path, ['.jpg', '.jpeg', '.png']))
                    <img src="{{ asset('storage/' . $weeklyDiagram->file_path) }}" class="max-w-xs rounded border border-gray-200">
                @else
                    <a href="{{ asset('storage/' . $weeklyDiagram->file_path) }}" target="_blank" class="text-[#0EA5B7] hover:underline">View uploaded PDF</a>
                @endif
            @else
                <p class="text-gray-500">No diagram uploaded for this week yet.</p>
            @endif
        </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">
                    {{ $logEntry->internship->student->name }} — {{ $logEntry->date }}
                </h3>

                <div class="mb-4">
                    <span class="block font-medium text-sm text-gray-700 mb-1">Operations Carried Out</span>
                    <p class="text-gray-800">{{ $logEntry->operations_carried_out }}</p>
                </div>

                <div class="mb-4">
                    <span class="block font-medium text-sm text-gray-700 mb-1">Tools &amp; Equipment Used</span>
                    <p class="text-gray-800">{{ $logEntry->tools_equipment_used }}</p>
                </div>

                @if ($logEntry->challenges_faced)
                    <div class="mb-4">
                        <span class="block font-medium text-sm text-gray-700 mb-1">Challenges Faced</span>
                        <p class="text-gray-800">{{ $logEntry->challenges_faced }}</p>
                    </div>
                @endif

                @if ($logEntry->recommendations)
                    <div class="mb-4">
                        <span class="block font-medium text-sm text-gray-700 mb-1">Recommendations</span>
                        <p class="text-gray-800">{{ $logEntry->recommendations }}</p>
                    </div>
                @endif
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Your Review</h3>

                <form method="POST" action="{{ route('reviews.store', $logEntry->id) }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700 mb-1">Comment</label>
                        <textarea name="comment" rows="3" maxlength="1000"
                                  class="border-gray-300 rounded w-full"
                                  placeholder="Optional feedback for the student...">{{ old('comment') }}</textarea>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit" name="status" value="approved"
                                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                            Approve
                        </button>
                        <button type="submit" name="status" value="needs_revision"
                                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                            Request Revision
                        </button>
                        <a href="{{ route('reviews.index') }}"
                           class="inline-flex items-center gap-1 px-4 py-2 border border-gray-300 text-gray-700 rounded hover:bg-gray-500 hover:text-white hover:border-gray-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>