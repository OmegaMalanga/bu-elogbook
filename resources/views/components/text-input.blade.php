@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-slate-300 bg-slate-50 text-slate-900 focus:border-[#0EA5B7] focus:ring-2 focus:ring-[#0EA5B7]/40 rounded-md shadow-sm']) }}>