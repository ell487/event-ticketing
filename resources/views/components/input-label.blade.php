@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-slate-400 mb-1.5']) }}>
    {{ $value ?? $slot }}
</label>