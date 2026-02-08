@php
    $alignment = $data['alignment'] ?? 'left';
    $image = null;
    if (!empty($data['image'])) {
        $image = \Illuminate\Support\Str::startsWith($data['image'], ['http://', 'https://'])
            ? $data['image']
            : asset('storage/' . $data['image']);
    }
@endphp
<section class="py-16 bg-white">
    <div class="container grid gap-6 md:grid-cols-2 {{ $alignment === 'right' ? 'reverse' : '' }}">
        <div>
            @if($image)
                <img class="w-full h-auto" src="{{ $image }}" alt="{{ $data['caption'] ?? '' }}">
            @endif
        </div>
        <div>
            @if(!empty($data['caption']))
                <h3 class="text-xl font-semibold">{{ $data['caption'] }}</h3>
            @endif
        </div>
    </div>
</section>
