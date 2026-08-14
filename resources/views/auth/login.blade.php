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
    <div class="relative" x-data="{ show: false }">
        <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password"
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