@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-[#1E2A78]']) }}>
    {{ $value ?? $slot }}
</label>