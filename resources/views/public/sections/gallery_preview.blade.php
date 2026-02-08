@php
    $categoryId = $data['category_id'] ?? null;
    $limit = $data['limit'] ?? 6;
    $query = \App\Models\GalleryImage::query()->with('category')->orderBy('position');
    if ($categoryId) {
        $query->where('category_id', $categoryId);
    }
    $images = $query->limit($limit)->get();
@endphp
<section class="py-16 bg-white">
    <div class="container">
        @if(!empty($data['title']))
            <h2 class="text-2xl font-semibold">{{ $data['title'] }}</h2>
        @endif
        <div class="grid gap-4 md:grid-cols-4">
            @foreach($images as $image)
                <img class="w-full h-44 object-cover rounded-xl" src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->caption ?? 'Gallery image' }}">
            @endforeach
        </div>
    </div>
</section>
