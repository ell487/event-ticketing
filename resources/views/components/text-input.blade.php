@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-slate-700 bg-slate-900 text-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-inner shadow-slate-950 w-full py-2.5 transition-all duration-200']) }}>