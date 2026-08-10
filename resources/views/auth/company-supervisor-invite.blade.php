<x-guest-layout>
    <form method="POST" action="{{ route('company-supervisor.invite.register', ['token' => $token]) }}">
        @csrf

        <p class="text-sm text-slate-600 mb-4">
            You've been invited as the company supervisor for
            <strong class="text-[#1E2A78]">{{ $student->name }}</strong>'s internship at
            <strong class="text-[#1E2A78]">{{ $internship->company_name }}</strong>.
            Set your name and password to create your account.
        </p>

        {{-- Email (read-only) --}}
        <div>
            <label class="block text-sm font-semibold text-[#1E2A78] mb-1">Email</label>
            <input type="email" value="{{ $internship->pending_company_supervisor_email }}" disabled
                class="w-full rounded-md border border-slate-300 bg-slate-100 px-3 py-2 text-slate-500">
        </div>

        {{-- Name --}}
        <div class="mt-4">
            <label for="name" class="block text-sm font-semibold text-[#1E2A78] mb-1">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2
                    focus:border-[#0EA5B7] focus:ring-2 focus:ring-[#0EA5B7]/40 focus:outline-none">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mt-4">
            <label for="password" class="block text-sm font-semibold text-[#1E2A78] mb-1">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2
                    focus:border-[#0EA5B7] focus:ring-2 focus:ring-[#0EA5B7]/40 focus:outline-none">
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="mt-4">
            <label for="password_confirmation" class="block text-sm font-semibold text-[#1E2A78] mb-1">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2
                    focus:border-[#0EA5B7] focus:ring-2 focus:ring-[#0EA5B7]/40 focus:outline-none">
            @error('password_confirmation')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-6 flex items-center justify-end">
            <button type="submit"
                class="px-6 py-2 rounded-md font-semibold text-white bg-gradient-to-r from-[#FF9F1C] to-[#FF7A1C]
                    shadow-md hover:shadow-lg hover:brightness-105 active:scale-[0.98]">
                CREATE ACCOUNT
            </button>
        </div>
    </form>
</x-guest-layout>