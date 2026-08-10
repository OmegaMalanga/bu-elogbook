<x-guest-layout>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-semibold text-[#1E2A78] mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2 text-slate-900
                       focus:border-[#0EA5B7] focus:ring-2 focus:ring-[#0EA5B7]/40 focus:outline-none transition" />
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mt-4">
            <label for="password" class="block text-sm font-semibold text-[#1E2A78] mb-1">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full rounded-md border border-slate-300 bg-slate-50 px-3 py-2 text-slate-900
                       focus:border-[#0EA5B7] focus:ring-2 focus:ring-[#0EA5B7]/40 focus:outline-none transition" />
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember me --}}
        <div class="mt-4 flex items-center">
            <input id="remember_me" type="checkbox" name="remember"
                class="rounded border-slate-400 text-[#0EA5B7] focus:ring-[#0EA5B7]" />
            <label for="remember_me" class="ml-2 text-sm text-slate-700 font-medium">Remember me</label>
        </div>

        {{-- Actions --}}
        <div class="mt-6 flex items-center justify-between">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-sm font-medium text-[#0EA5B7] hover:text-[#12587A] underline">
                    Forgot your password?
                </a>
            @endif

            <button type="submit"
                class="px-6 py-2 rounded-md font-semibold text-white bg-gradient-to-r from-[#FF9F1C] to-[#FF7A1C]
                       shadow-md hover:shadow-lg hover:brightness-105 active:scale-[0.98] transition">
                LOG IN
            </button>
        </div>
    </form>
</x-guest-layout>