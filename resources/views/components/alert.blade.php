@props(['type' => 'info'])
@php
    $map = [
        'success' => 'bg-emerald-100 text-emerald-800',
        'error' => 'bg-red-100 text-red-800',
        'info' => 'bg-neutral-100 text-neutral-800',
    ];
    $classes = 'rounded-lg px-4 py-3 mb-4 ' . ($map[$type] ?? $map['info']);
@endphp
<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
