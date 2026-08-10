<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Daily Report
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('log-entries.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700 mb-1">Report Date *</label>
                        <input type="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}"
                               class="border-gray-300 rounded w-full" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700 mb-1">Operations Carried Out *</label>
                        <textarea name="operations_carried_out" rows="4" maxlength="1000"
                                  class="border-gray-300 rounded w-full"
                                  placeholder="Describe the tasks and operations you carried out today..."
                                  required>{{ old('operations_carried_out') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700 mb-1">Tools &amp; Equipment Used *</label>
                        <textarea name="tools_equipment_used" rows="2" maxlength="500"
                                  class="border-gray-300 rounded w-full"
                                  placeholder="List the tools or equipment you used today..."
                                  required>{{ old('tools_equipment_used') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700 mb-1">Challenges Faced</label>
                        <textarea name="challenges_faced" rows="3" maxlength="500"
                                  class="border-gray-300 rounded w-full"
                                  placeholder="Any challenges or obstacles you faced? (optional)">{{ old('challenges_faced') }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block font-medium text-sm text-gray-700 mb-1">Recommendations</label>
                        <textarea name="recommendations" rows="3" maxlength="500"
                                  class="border-gray-300 rounded w-full"
                                  placeholder="Suggestions for improvement or future actions (optional)">{{ old('recommendations') }}</textarea>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit" name="action" value="draft"
                                class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                            Save as Draft
                        </button>
                        <button type="submit" name="action" value="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Submit Report
                        </button>
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center gap-1 px-4 py-2 border border-gray-300 text-gray-700 rounded hover:bg-gray-500 hover:text-white hover:border-gray-500">
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