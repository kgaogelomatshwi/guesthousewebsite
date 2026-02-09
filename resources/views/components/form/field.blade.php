@props([
    'label',
    'name',
    'type' => 'text',
    'value' => null,
    'min' => null,
    'required' => false,
])

@php
    $id = $attributes->get('id') ?? $name;
@endphp

<div class="grid gap-2">
    <label for="{{ $id }}" class="text-xs uppercase tracking-wider text-neutral-600">{{ $label }}</label>
    <input
        id="{{ $id }}"
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ $value }}"
        @if($min !== null) min="{{ $min }}" @endif
        @if($required) required @endif
        {{ $attributes->except(['id']) }}
    >
</div>
