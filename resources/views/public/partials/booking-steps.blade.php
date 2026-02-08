@php
    $current = $current ?? 'choose';
    $steps = [
        'choose' => 'Choose your room',
        'details' => 'Enter booking details',
        'checkout' => 'Checkout',
        'payment' => 'Preferred payment',
        'confirm' => 'Confirmation email',
    ];
@endphp

<div class="flex flex-wrap gap-3 text-sm uppercase tracking-wider">
    @foreach($steps as $key => $label)
        <span class="{{ $current === $key ? 'text-black font-semibold' : 'text-neutral-400' }}">{{ $label }}</span>
        @if(!$loop->last)
            <span class="text-neutral-300">/</span>
        @endif
    @endforeach
</div>
