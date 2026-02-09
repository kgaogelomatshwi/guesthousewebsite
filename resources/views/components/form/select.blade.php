@props([
    'label',
    'name',
    'options' => [],
    'selected' => null,
])

@php
    $id = $attributes->get('id') ?? $name;
@endphp

<div class="grid gap-2">
    <label for="{{ $id }}" class="text-xs uppercase tracking-wider text-neutral-600">{{ $label }}</label>
    <select id="{{ $id }}" name="{{ $name }}" {{ $attributes->except(['id']) }}>
        @foreach($options as $value => $text)
            <option value="{{ $value }}" @selected((string) $selected === (string) $value)>{{ $text }}</option>
        @endforeach
    </select>
</div>
