<section class="py-16 bg-white">
    <div class="container">
        @if(!empty($data['title']))
            <h2 class="text-2xl font-semibold">{{ $data['title'] }}</h2>
        @endif
        @if(!empty($data['subtitle']))
            <p class="text-neutral-600">{{ $data['subtitle'] }}</p>
        @endif

        <div class="bg-white -mt-10 p-6 rounded-2xl shadow-lg border border-black/10">
            @include('public.partials.ota-redirect-form')
        </div>
    </div>
</section>
