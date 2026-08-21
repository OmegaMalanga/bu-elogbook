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
    <div class="relative" x-data="{ show: false }">
        <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="new-password"
            class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2 text-sm pr-10
                focus:border-[#0EA5B7] focus:ring-2 focus:ring-[#0EA5B7]/40 focus:outline-none">
        <button type="button" @click="show = !show"
            class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600">
            <svg x-show="!show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            <svg x-show="show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
            </svg>
        </button>
    </div>
    @error('password')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

        {{-- Confirm Password --}}
<div class="mt-4">
    <label for="password_confirmation" class="block text-sm font-semibold text-[#1E2A78] mb-1">Confirm Password</label>
    <div class="relative" x-data="{ show: false }">
        <input id="password_confirmation" :type="show ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password"
            class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2 text-sm pr-10
                focus:border-[#0EA5B7] focus:ring-2 focus:ring-[#0EA5B7]/40 focus:outline-none">
        <button type="button" @click="show = !show"
            class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600">
            <svg x-show="!show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            <svg x-show="show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
            </svg>
        </button>
    </div>
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
            <label for="pending_company_supervisor_name" class="block text-sm font-semibold text-[#1E2A78] mb-1">Company Supervisor Name</label>
            <input id="pending_company_supervisor_name" type="text" name="pending_company_supervisor_name" value="{{ old('pending_company_supervisor_name') }}" required autocomplete="off"
                class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2 text-sm
                focus:border-[#0EA5B7] focus:ring-2 focus:ring-[#0EA5B7]/40 focus:outline-none">
            @error('pending_company_supervisor_name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4">
            <label for="pending_company_supervisor_email" class="block text-sm font-semibold text-[#1E2A78] mb-1">Company Supervisor Email</label>
            <input id="pending_company_supervisor_email" type="email" name="pending_company_supervisor_email" value="{{ old('pending_company_supervisor_email') }}" required autocomplete="off"
                class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2 text-sm
                focus:border-[#0EA5B7] focus:ring-2 focus:ring-[#0EA5B7]/40 focus:outline-none">
            <p class="mt-1 text-xs text-slate-500">We'll send them an invite to join and review your reports.</p>
            @error('pending_company_supervisor_email')
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
 
</x-guest-layout>