<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Evaluate Intern') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">

                <p class="text-sm text-gray-500 mb-1">Student</p>
                <p class="text-lg font-semibold text-[#1E2A78] mb-6">{{ $internship->student->name }}</p>

                @if ($evaluation->company_supervisor_submitted_at)
                    <div class="mb-4 px-4 py-2 rounded-md bg-[#0EA5B7]/10 text-[#0E7490] text-sm">
                        You already submitted this evaluation on {{ $evaluation->company_supervisor_submitted_at->format('d M Y') }}. Submitting again will update it.
                    </div>
                @endif

                <form method="POST" action="{{ route('evaluations.update', $internship) }}">
                    @csrf

                    @php
                        $criteria = [
                            'technical_competence' => 'Technical Competence',
                            'punctuality_attendance' => 'Punctuality & Attendance',
                            'initiative_problem_solving' => 'Initiative & Problem-Solving',
                            'professionalism_work_ethic' => 'Professionalism & Work Ethic',
                            'communication_teamwork' => 'Communication & Teamwork',
                        ];
                    @endphp

                    @foreach ($criteria as $field => $label)
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-[#1E2A78] mb-1">
                                {{ $label }} <span class="text-gray-400 font-normal">(out of 20)</span>
                            </label>
                            <input type="number" name="{{ $field }}" min="0" max="20"
                                value="{{ old($field, $evaluation->$field) }}"
                                class="w-32 rounded-md border border-slate-300 bg-slate-50 focus:border-[#0EA5B7] focus:ring-2 focus:ring-[#0EA5B7]/40"
                                required>
                            @error($field)
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach

                    <button type="submit"
                        class="mt-4 px-6 py-2 rounded-md font-semibold text-white bg-gradient-to-r from-[#FF9F1C] to-[#FF7A1C]">
                        Submit Evaluation
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>