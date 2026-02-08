@props(['href' => null, 'variant' => 'primary'])

@php
    $base = 'inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent transition';
    $variants = [
        'primary' => 'bg-black text-white shadow-lg',
        'outline' => 'bg-transparent border-black text-black',
        'ghost' => 'bg-transparent text-black',
    ];
    $classes = trim($base . ' ' . ($variants[$variant] ?? $variants['primary']));
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button type="button" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
