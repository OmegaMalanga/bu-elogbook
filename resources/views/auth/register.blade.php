<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Name --}}
        <div>
            <label for="name" class="block text-sm font-semibold text-[#1E2A78] mb-1">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2 text-slate-900
                       focus:border-[#0EA5B7] focus:ring-2 focus:ring-[#0EA5B7]/40 focus:outline-none transition" />
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mt-4">
            <label for="email" class="block text-sm font-semibold text-[#1E2A78] mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2 text-slate-900
                       focus:border-[#0EA5B7] focus:ring-2 focus:ring-[#0EA5B7]/40 focus:outline-none transition" />
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mt-4">
            <label for="password" class="block text-sm font-semibold text-[#1E2A78] mb-1">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2 text-slate-900
                       focus:border-[#0EA5B7] focus:ring-2 focus:ring-[#0EA5B7]/40 focus:outline-none transition" />
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="mt-4">
            <label for="password_confirmation" class="block text-sm font-semibold text-[#1E2A78] mb-1">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2 text-slate-900
                       focus:border-[#0EA5B7] focus:ring-2 focus:ring-[#0EA5B7]/40 focus:outline-none transition" />
            @error('password_confirmation')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Department --}}
        <div class="mt-4">
            <label for="department_id" class="block text-sm font-semibold text-[#1E2A78] mb-1">Engineering Department</label>
            <select id="department_id" name="department_id"
                class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2 text-slate-900
                       focus:border-[#0EA5B7] focus:ring-2 focus:ring-[#0EA5B7]/40 focus:outline-none transition">
                <option value="">— Select —</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
            @error('department_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Year of Study --}}
        <div class="mt-4">
            <label for="year_of_study" class="block text-sm font-semibold text-[#1E2A78] mb-1">Year of Study</label>
            <select id="year_of_study" name="year_of_study"
                class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2 text-slate-900
                       focus:border-[#0EA5B7] focus:ring-2 focus:ring-[#0EA5B7]/40 focus:outline-none transition">
                <option value="">— Select —</option>
                <option value="2" @selected(old('year_of_study') == 2)>Year 2</option>
                <option value="3" @selected(old('year_of_study') == 3)>Year 3</option>
            </select>
            @error('year_of_study')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Company Name --}}
        <div class="mt-4">
            <label for="company_name" class="block text-sm font-semibold text-[#1E2A78] mb-1">Company Name</label>
            <input id="company_name" type="text" name="company_name" value="{{ old('company_name') }}"
                class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2 text-slate-900
                       focus:border-[#0EA5B7] focus:ring-2 focus:ring-[#0EA5B7]/40 focus:outline-none transition" />
            @error('company_name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Company Supervisor --}}
<div class="mt-4">
    <label for="pending_company_supervisor_name" class="block text-sm font-semibold text-[#1E2A78] mb-1">Company Supervisor Name <span class="font-normal text-slate-400">(optional)</span></label>
    <input id="pending_company_supervisor_name" type="text" name="pending_company_supervisor_name" value="{{ old('pending_company_supervisor_name') }}"
        class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2 text-sm
            focus:border-[#0EA5B7] focus:ring-2 focus:ring-[#0EA5B7]/40 focus:outline-none">
    @error('pending_company_supervisor_name')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div class="mt-4">
    <label for="pending_company_supervisor_email" class="block text-sm font-semibold text-[#1E2A78] mb-1">Company Supervisor Email <span class="font-normal text-slate-400">(optional)</span></label>
    <input id="pending_company_supervisor_email" type="email" name="pending_company_supervisor_email" value="{{ old('pending_company_supervisor_email') }}"
        class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2 text-sm
            focus:border-[#0EA5B7] focus:ring-2 focus:ring-[#0EA5B7]/40 focus:outline-none">
    <p class="mt-1 text-xs text-slate-500">If provided, we'll send them an invite to join and review your reports.</p>
    @error('pending_company_supervisor_email')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

        {{-- University Supervisor --}}
<div class="mt-4">
    <label for="university_supervisor_id" class="block text-sm font-semibold text-[#1E2A78] mb-1">University Supervisor</label>
    <select id="university_supervisor_id" name="university_supervisor_id"
        class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2 text-sm
            focus:border-[#0EA5B7] focus:ring-2 focus:ring-[#0EA5B7]/40 focus:outline-none">
        <option value="">— Select your department first —</option>
    </select>
    <p id="no_supervisors_note" class="mt-1 text-sm text-slate-500 hidden">
        No university supervisors registered yet for this department — contact admin.
    </p>
    @error('university_supervisor_id')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

        {{-- Actions --}}
        <div class="mt-6 flex items-center justify-between">
            <a href="{{ route('login') }}" class="text-sm font-medium text-[#0EA5B7] hover:text-[#12587A] underline">
                Already registered?
            </a>

            <button type="submit"
                class="px-6 py-2 rounded-md font-semibold text-white bg-gradient-to-r from-[#FF9F1C] to-[#FF7A1C]
                       shadow-md hover:shadow-lg hover:brightness-105 active:scale-[0.98] transition">
                REGISTER
            </button>
        </div>
    </form>
    <script>
    const universitySupervisors = @json($universitySupervisors);
    const oldDepartmentId = @json(old('department_id'));
    const oldSupervisorId = @json(old('university_supervisor_id'));

    function populateSupervisors(departmentId) {
        const select = document.getElementById('university_supervisor_id');
        const note = document.getElementById('no_supervisors_note');
        select.innerHTML = '';

        if (!departmentId) {
            select.innerHTML = '<option value="">— Select your department first —</option>';
            note.classList.add('hidden');
            return;
        }

        const matches = universitySupervisors.filter(s => String(s.department_id) === String(departmentId));

        if (matches.length === 0) {
            select.innerHTML = '<option value="">— None available —</option>';
            note.classList.remove('hidden');
            return;
        }

        note.classList.add('hidden');
        select.innerHTML = '<option value="">— Select a supervisor —</option>';
        matches.forEach(s => {
            const opt = document.createElement('option');
            opt.value = s.id;
            opt.textContent = s.name;
            if (oldSupervisorId && String(oldSupervisorId) === String(s.id)) {
                opt.selected = true;
            }
            select.appendChild(opt);
        });
    }

    document.getElementById('department_id').addEventListener('change', function () {
        populateSupervisors(this.value);
    });

    document.addEventListener('DOMContentLoaded', function () {
        if (oldDepartmentId) {
            populateSupervisors(oldDepartmentId);
        }
    });
</script>
</x-guest-layout>