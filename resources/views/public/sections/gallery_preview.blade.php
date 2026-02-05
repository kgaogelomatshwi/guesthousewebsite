@php
    $categoryId = $data['category_id'] ?? null;
    $limit = $data['limit'] ?? 6;
    $query = \App\Models\GalleryImage::query()->with('category')->orderBy('position');
    if ($categoryId) {
        $query->where('category_id', $categoryId);
    }
    $images = $query->limit($limit)->get();
@endphp
<section class="section section-light">
    <div class="container">
        @if(!empty($data['title']))
            <h2>{{ $data['title'] }}</h2>
        @endif
        <div class="grid-4">
            @foreach($images as $image)
                <img class="gallery-img" src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->caption ?? 'Gallery image' }}">
            @endforeach
        </div>
    </div>
</section>
