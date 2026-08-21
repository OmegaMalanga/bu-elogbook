<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Manage Internships
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-4 mb-6">
                <form method="GET" action="{{ route('department.internships.index') }}" class="flex flex-wrap items-end gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-[#1E2A78] mb-1">Search Student</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Student name"
                            class="rounded-md border border-slate-300 bg-slate-50 focus:border-[#0EA5B7]">
                    </div>
                    <button type="submit"
                        class="px-4 py-2 rounded-md font-semibold text-white bg-gradient-to-r from-[#FF9F1C] to-[#0EA5B7]">
                        Filter
                    </button>
                    @if (request('search'))
                        <a href="{{ route('department.internships.index') }}" class="text-sm text-[#0EA5B7]">Clear</a>
                    @endif
                </form>
            </div>

            {{-- One form per internship, placed outside the table --}}
            @foreach ($internships as $internship)
                <form id="internship-form-{{ $internship->id }}"
                    method="POST"
                    action="{{ route('department.internships.update', $internship) }}">
                    @csrf
                    @method('PATCH')
                </form>
            @endforeach

            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Student</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">University Supervisor</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($internships as $internship)
                            @php
                                $formId = 'internship-form-' . $internship->id;
                                $needsAssignment = is_null($internship->university_supervisor_id);
                            @endphp
                            <tr class="{{ $needsAssignment ? 'bg-amber-50' : '' }}">
                                <td class="px-4 py-3 whitespace-nowrap text-gray-900">
                                    {{ $internship->student->name }}
                                </td>
                                <td class="px-4 py-3">
                                    <select name="university_supervisor_id" form="{{ $formId }}"
                                        class="rounded-md border-gray-300 shadow-sm text-sm w-full">
                                        <option value="">— None —</option>
                                        @foreach ($universitySupervisors as $supervisor)
                                            <option value="{{ $supervisor->id }}"
                                                @selected($internship->university_supervisor_id === $supervisor->id)>
                                                {{ $supervisor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if ($needsAssignment)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                            Needs Assignment
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                            Complete
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <button type="submit" form="{{ $formId }}"
                                        class="inline-flex items-center px-3 py-1.5 rounded-md font-semibold text-white bg-gradient-to-r from-[#FF9F1C] to-[#0EA5B7]">
                                        Save
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                                    No internships found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $internships->links() }}
            </div>

        </div>
    </div>
</x-app-layout>