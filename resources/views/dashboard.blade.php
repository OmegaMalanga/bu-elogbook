<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @role('student')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border-t-4 border-[#0EA5B7] p-4">
            <p class="text-sm text-gray-500">This Week's Reports</p>
            <p class="text-2xl font-bold text-[#1E2A78]">{{ $weeklyCount ?? 0 }}</p>
        </div>
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border-t-4 border-[#0EA5B7] p-4">
            <p class="text-sm text-gray-500">This Month's Reports</p>
            <p class="text-2xl font-bold text-[#1E2A78]">{{ $monthlyCount ?? 0 }}</p>
        </div>
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border-t-4 border-[#FF9F1C] p-4">
            <p class="text-sm text-gray-500">Department</p>
            <p class="text-lg font-semibold text-[#1E2A78]">
                {{ $internship->department->name ?? 'Not set' }}
            </p>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-[#1E2A78]">Recent Reports</h3>
            <a href="{{ route('log-entries.create') }}"
               class="px-4 py-2 rounded-md font-semibold text-white bg-gradient-to-r from-[#FF9F1C] to-[#FF7A1C] shadow-md hover:brightness-105 transition">
                + New Report
            </a>
        </div>

        @if (!$internship)
            <p class="text-gray-500">
                You do not have an internship record yet. Please contact your administrator.
            </p>
        @elseif ($recentEntries->isEmpty())
            <p class="text-gray-500">No reports yet. Create your first report above.</p>
        @else
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="pb-2 text-sm text-gray-500">Date</th>
                        <th class="pb-2 text-sm text-gray-500">Operations Carried Out</th>
                        <th class="pb-2 text-sm text-gray-500">Status</th>
                        <th class="pb-2 text-sm text-gray-500">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentEntries as $entry)
                        <tr class="border-b border-gray-200">
                            <td class="py-3 text-gray-800">{{ $entry->date }}</td>
                            <td class="py-3 text-gray-800">
                                {{ Str::limit($entry->operations_carried_out, 50) }}
                            </td>
                            <td class="py-3">
                                @if ($entry->status === 'draft')
                                    <span class="px-2 py-1 text-xs rounded-full bg-slate-200 text-slate-700">Draft</span>
                                @elseif ($entry->status === 'submitted')
                                    <span class="px-2 py-1 text-xs rounded-full bg-[#FF9F1C]/20 text-[#B96A00]">Submitted</span>
                                @elseif ($entry->status === 'reviewed')
                                    <span class="px-2 py-1 text-xs rounded-full bg-[#0EA5B7]/20 text-[#0B7A87]">Reviewed</span>
                                @endif
                            </td>
                            <td class="py-3">
                                @if ($entry->status === 'draft')
                                    <a href="{{ route('log-entries.edit', $entry) }}"
                                       class="text-[#0EA5B7] hover:text-[#12587A] font-medium underline">
                                        Edit
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4 text-right">
                <a href="{{ route('log-entries.my-reports') }}"
                   class="inline-block px-4 py-2 rounded-md font-semibold text-white bg-gradient-to-r from-[#1E2A78] to-[#0EA5B7] shadow-md hover:brightness-105 transition">
                    View All Reports
                </a>
            </div>
        @endif
    </div>
@endrole
            @role('company_supervisor')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border-t-4 border-[#FF9F1C] p-4">
            <p class="text-sm text-gray-500">Reports Awaiting You</p>
            <p class="text-2xl font-bold text-[#1E2A78]">{{ $pendingCount }}</p>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-[#1E2A78]">
                Reports Awaiting Your Review (Company Supervisor)
            </h3>
            <a href="{{ route('reviews.index') }}" class="text-[#0EA5B7] hover:text-[#12587A] font-medium">
                View All →
            </a>
        </div>

        @if ($pendingEntries->isEmpty())
            <p class="text-gray-500">No reports currently awaiting your review.</p>
        @else
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="pb-2 text-sm text-gray-500">Date</th>
                        <th class="pb-2 text-sm text-gray-500">Student</th>
                        <th class="pb-2 text-sm text-gray-500">Operations Carried Out</th>
                        <th class="pb-2 text-sm text-gray-500">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendingEntries as $entry)
                        <tr class="border-b border-gray-200">
                            <td class="py-3 text-gray-800">{{ $entry->date }}</td>
                            <td class="py-3 text-gray-800">{{ $entry->internship->student->name }}</td>
                            <td class="py-3 text-gray-800">
                                {{ Str::limit($entry->operations_carried_out, 50) }}
                            </td>
                            <td class="py-3">
                                <a href="{{ route('reviews.show', $entry->id) }}"
                                   class="px-3 py-1 rounded-md font-semibold text-white bg-gradient-to-r from-[#FF9F1C] to-[#FF7A1C] shadow-sm hover:brightness-105 transition">
                                    Review
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mt-6">
                <h3 class="text-lg font-semibold text-[#1E2A78] mb-4">My Interns &mdash; Evaluations</h3>

                @if ($internships->isEmpty())
                    <p class="text-gray-500">You are not currently assigned as company supervisor to any interns.</p>
                @else
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="pb-2 text-sm text-gray-500">Student</th>
                                <th class="pb-2 text-sm text-gray-500">Status</th>
                                <th class="pb-2 text-sm text-gray-500">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($internships as $internship)
                                <tr class="border-b border-gray-200">
                                    <td class="py-3 text-gray-800">{{ $internship->student->name }}</td>
                                    <td class="py-3">
                                        @if ($internship->evaluation && $internship->evaluation->company_supervisor_submitted_at)
                                            <span class="px-2 py-1 text-xs rounded-full bg-[#0EA5B7]/20 text-[#0E7490]">Evaluated</span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-[#FF9F1C]/20 text-[#B45309]">Not Evaluated</span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        <a href="{{ route('evaluations.edit', $internship) }}"
                                            class="px-3 py-1 rounded-md font-semibold text-white bg-gradient-to-r from-[#FF9F1C] to-[#FF7A1C]">
                                            Evaluate Intern
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
@endrole
            @role('university_supervisor')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border-t-4 border-[#FF9F1C] p-4">
            <p class="text-sm text-gray-500">Reports Awaiting You</p>
            <p class="text-2xl font-bold text-[#1E2A78]">{{ $pendingCount }}</p>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-[#1E2A78]">
                Reports Awaiting Your Review (University Supervisor)
            </h3>
            <a href="{{ route('reviews.index') }}" class="text-[#0EA5B7] hover:text-[#12587A] font-medium">
                View All →
            </a>
        </div>

        @if ($pendingEntries->isEmpty())
            <p class="text-gray-500">No reports currently awaiting your review.</p>
        @else
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="pb-2 text-sm text-gray-500">Date</th>
                        <th class="pb-2 text-sm text-gray-500">Student</th>
                        <th class="pb-2 text-sm text-gray-500">Operations Carried Out</th>
                        <th class="pb-2 text-sm text-gray-500">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendingEntries as $entry)
                        <tr class="border-b border-gray-200">
                            <td class="py-3 text-gray-800">{{ $entry->date }}</td>
                            <td class="py-3 text-gray-800">{{ $entry->internship->student->name }}</td>
                            <td class="py-3 text-gray-800">
                                {{ Str::limit($entry->operations_carried_out, 50) }}
                            </td>
                            <td class="py-3">
                                <a href="{{ route('reviews.show', $entry->id) }}"
                                   class="px-3 py-1 rounded-md font-semibold text-white bg-gradient-to-r from-[#FF9F1C] to-[#FF7A1C] shadow-sm hover:brightness-105 transition">
                                    Review
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mt-6">
                <h3 class="text-lg font-semibold text-[#1E2A78] mb-4">My Interns &mdash; Final Grades</h3>

                @if ($internships->isEmpty())
                    <p class="text-gray-500">You are not currently assigned as university supervisor to any interns.</p>
                @else
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="pb-2 text-sm text-gray-500">Student</th>
                                <th class="pb-2 text-sm text-gray-500">Final Grade</th>
                                <th class="pb-2 text-sm text-gray-500">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($internships as $internship)
                                <tr class="border-b border-gray-200">
                                    <td class="py-3 text-gray-800">{{ $internship->student->name }}</td>
                                    <td class="py-3">
                                        @if ($internship->evaluation && $internship->evaluation->final_grade !== null)
                                            <span class="px-2 py-1 text-xs rounded-full bg-[#0EA5B7]/20 text-[#0E7490]">{{ $internship->evaluation->final_grade }}%</span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-[#FF9F1C]/20 text-[#B45309]">Not Graded</span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        <a href="{{ route('evaluations.grade', $internship) }}"
                                            class="px-3 py-1 rounded-md font-semibold text-white bg-gradient-to-r from-[#FF9F1C] to-[#FF7A1C]">
                                            Assign Final Grade
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
@endrole

          @role('admin')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border-t-4 border-[#0EA5B7] p-6">
            <p class="text-sm text-gray-500">Total Students</p>
            <p class="text-2xl font-bold text-[#1E2A78]">{{ $facultyTotals['students'] }}</p>
        </div>
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border-t-4 border-[#0EA5B7] p-6">
            <p class="text-sm text-gray-500">Total Internships</p>
            <p class="text-2xl font-bold text-[#1E2A78]">{{ $facultyTotals['internships'] }}</p>
        </div>
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border-t-4 border-[#FF9F1C] p-6">
            <p class="text-sm text-gray-500">Pending Reviews (Faculty-wide)</p>
            <p class="text-2xl font-bold text-[#1E2A78]">{{ $facultyTotals['pending_reviews'] }}</p>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-[#1E2A78] mb-4">By Department</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach ($departmentStats as $stat)
                <div class="border border-gray-200 rounded-lg p-4">
                    <p class="text-sm font-semibold text-[#1E2A78] mb-2">{{ $stat['name'] }}</p>
                    @foreach ([2, 3] as $year)
                        <div class="mb-2 last:mb-0">
                            <p class="text-xs font-medium text-[#0EA5B7]">Year {{ $year }}</p>
                            <p class="text-xs text-gray-500 pl-2">
                                Students: <span class="font-medium text-gray-700">{{ $stat['years'][$year]['students_count'] }}</span>
                            </p>
                            <p class="text-xs text-gray-500 pl-2">
                                Pending Reviews:
                                <span class="font-medium {{ $stat['years'][$year]['pending_reviews_count'] > 0 ? 'text-[#FF9F1C]' : 'text-gray-700' }}">
                                    {{ $stat['years'][$year]['pending_reviews_count'] }}
                                </span>
                            </p>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h3 class="text-lg font-semibold text-[#1E2A78] mb-4">
            Administration
        </h3>
        <a href="{{ route('admin.users.index') }}"
           class="inline-block px-4 py-2 rounded-md font-semibold text-white bg-gradient-to-r from-[#1E2A78] to-[#0EA5B7] shadow-md hover:brightness-105 transition mr-3 mb-2">
            Manage Users →
        </a>
        <a href="{{ route('admin.internships.index') }}"
           class="inline-block px-4 py-2 rounded-md font-semibold text-white bg-gradient-to-r from-[#1E2A78] to-[#0EA5B7] shadow-md hover:brightness-105 transition mb-2">
            Manage Internships →
        </a>
    </div>
@endrole

        </div>
    </div>
</x-app-layout>