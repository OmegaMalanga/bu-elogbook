<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Stat cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg border-t-4 border-[#0EA5B7] p-4">
                    <p class="text-sm text-gray-500">Total Reports</p>
                    <p class="text-2xl font-bold text-[#1E2A78]">{{ $totalCount }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-lg border-t-4 border-slate-400 p-4">
                    <p class="text-sm text-gray-500">Draft</p>
                    <p class="text-2xl font-bold text-[#1E2A78]">{{ $draftCount }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-lg border-t-4 border-[#FF9F1C] p-4">
                    <p class="text-sm text-gray-500">Submitted</p>
                    <p class="text-2xl font-bold text-[#1E2A78]">{{ $submittedCount }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-lg border-t-4 border-[#0EA5B7] p-4">
                    <p class="text-sm text-gray-500">Reviewed</p>
                    <p class="text-2xl font-bold text-[#1E2A78]">{{ $reviewedCount }}</p>
                </div>
            </div>

            {{-- Filter panel --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-4 mb-6">
                <form method="GET" action="{{ route('log-entries.my-reports') }}" class="flex flex-wrap gap-4 items-end">
                    <div>
                        <label class="block text-sm font-semibold text-[#1E2A78] mb-1">Status</label>
                        <select name="status"
                            class="rounded-md border border-slate-300 bg-slate-50 text-slate-900 px-3 py-2
                                   focus:border-[#0EA5B7] focus:ring-2 focus:ring-[#0EA5B7]/40 focus:outline-none transition">
                            <option value="">All Statuses</option>
                            <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                            <option value="submitted" @selected(request('status') === 'submitted')>Submitted</option>
                            <option value="reviewed" @selected(request('status') === 'reviewed')>Reviewed</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-[#1E2A78] mb-1">From Date</label>
                        <input type="date" name="from_date" value="{{ request('from_date') }}"
                               class="rounded-md border border-slate-300 bg-slate-50 text-slate-900 px-3 py-2
                                      focus:border-[#0EA5B7] focus:ring-2 focus:ring-[#0EA5B7]/40 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-[#1E2A78] mb-1">To Date</label>
                        <input type="date" name="to_date" value="{{ request('to_date') }}"
                               class="rounded-md border border-slate-300 bg-slate-50 text-slate-900 px-3 py-2
                                      focus:border-[#0EA5B7] focus:ring-2 focus:ring-[#0EA5B7]/40 focus:outline-none transition">
                    </div>
                    <button type="submit"
                        class="px-4 py-2 rounded-md font-semibold text-white bg-gradient-to-r from-[#FF9F1C] to-[#FF7A1C] shadow-md hover:brightness-105 transition">
                        Filter
                    </button>
                </form>
                <a href="{{ route('log-entries.export-pdf', request()->only(['status', 'from_date', 'to_date'])) }}"
                    class="inline-block mt-3 px-4 py-2 rounded-md font-semibold text-white bg-gradient-to-r from-[#1E2A78] to-[#0EA5B7]">
                    Export PDF
                </a>
            </div>

            {{-- Reports list --}}
            <div class="space-y-4">
                @forelse ($entries as $entry)
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <p class="font-semibold text-[#1E2A78]">
                                {{ \Carbon\Carbon::parse($entry->date)->format('l, Y-m-d') }}
                            </p>
                            @if ($entry->status === 'draft')
                                <span class="px-2 py-1 text-xs rounded-full bg-slate-200 text-slate-700">Draft</span>
                            @elseif ($entry->status === 'submitted')
                                <span class="px-2 py-1 text-xs rounded-full bg-[#FF9F1C]/20 text-[#B96A00]">Submitted</span>
                            @elseif ($entry->status === 'reviewed')
                                <span class="px-2 py-1 text-xs rounded-full bg-[#0EA5B7]/20 text-[#0B7A87]">Reviewed</span>
                            @endif
                        </div>

                        <p class="text-sm text-gray-500 mb-1">Operations Carried Out:</p>
                        <p class="text-gray-800 mb-3">{{ $entry->operations_carried_out }}</p>

                        <p class="text-sm text-gray-500 mb-1">Tools & Equipment Used:</p>
                        <p class="text-gray-800 mb-3">{{ $entry->tools_equipment_used }}</p>

                        @if ($entry->challenges_faced)
                            <p class="text-sm text-gray-500 mb-1">Challenges Faced:</p>
                            <p class="text-gray-800 mb-3">{{ $entry->challenges_faced }}</p>
                        @endif

                        @if ($entry->recommendations)
                            <p class="text-sm text-gray-500 mb-1">Recommendations:</p>
                            <p class="text-gray-800 mb-3">{{ $entry->recommendations }}</p>
                        @endif

                        @if ($entry->status === 'draft')
                            <a href="{{ route('log-entries.edit', $entry) }}"
                               class="inline-block mt-2 px-3 py-1 rounded-md font-semibold text-white bg-gradient-to-r from-[#FF9F1C] to-[#FF7A1C] text-sm shadow-sm hover:brightness-105 transition">
                                Edit
                            </a>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500">No reports found for the selected filters.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>