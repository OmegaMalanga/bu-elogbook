<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Assign Final Grade') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">

                <p class="text-sm text-gray-500 mb-1">Student</p>
                <p class="text-lg font-semibold text-[#1E2A78] mb-6">{{ $internship->student->name }}</p>

                @if (session('error'))
                    <div class="mb-4 px-4 py-2 rounded-md bg-red-100 text-red-700 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="mb-6 p-4 rounded-md bg-slate-50 border border-slate-200">
                    <p class="text-sm font-semibold text-[#1E2A78] mb-2">Company Supervisor's Evaluation</p>
                    @if ($evaluation && $evaluation->company_supervisor_submitted_at)
                        <ul class="text-sm text-gray-700 space-y-1">
                            <li>Technical Competence: {{ $evaluation->technical_competence }}/20</li>
                            <li>Punctuality & Attendance: {{ $evaluation->punctuality_attendance }}/20</li>
                            <li>Initiative & Problem-Solving: {{ $evaluation->initiative_problem_solving }}/20</li>
                            <li>Professionalism & Work Ethic: {{ $evaluation->professionalism_work_ethic }}/20</li>
                            <li>Communication & Teamwork: {{ $evaluation->communication_teamwork }}/20</li>
                            <li class="font-bold mt-2">Total: {{ $evaluation->criteriaTotal() }}/100</li>
                        </ul>
                    @else
                        <p class="text-sm text-gray-500">Not yet submitted by the company supervisor.</p>
                    @endif
                </div>

                @if (!$allReviewed)
                    <div class="mb-4 px-4 py-2 rounded-md bg-amber-100 text-amber-700 text-sm">
                        All log entries must be reviewed before you can assign a final grade.
                    </div>
                @else
                    <form method="POST" action="{{ route('evaluations.update-grade', $internship) }}">
                        @csrf

                        <label class="block text-sm font-semibold text-[#1E2A78] mb-1">
                            Final Grade <span class="text-gray-400 font-normal">(%)</span>
                        </label>
                        <input type="number" name="final_grade" min="0" max="100" step="0.01"
                            value="{{ old('final_grade', $evaluation->final_grade ?? '') }}"
                            class="w-40 rounded-md border border-slate-300 bg-slate-50 focus:border-[#0EA5B7] focus:ring-2 focus:ring-[#0EA5B7]/40"
                            required>
                        @error('final_grade')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        <div>
                            <button type="submit"
                                class="mt-4 px-6 py-2 rounded-md font-semibold text-white bg-gradient-to-r from-[#FF9F1C] to-[#FF7A1C]">
                                Submit Final Grade
                            </button>
                        </div>
                    </form>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>