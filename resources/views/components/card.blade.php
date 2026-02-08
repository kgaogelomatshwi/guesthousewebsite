@props(['class' => ''])
<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl shadow-lg overflow-hidden border border-black/5 ' . $class]) }}>
    {{ $slot }}
</div>
