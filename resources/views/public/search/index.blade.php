@extends('public.layouts.app')

@section('content')
    <section class="py-20 bg-black text-white">
        <div class="container">
            <h1 class="text-4xl md:text-5xl uppercase tracking-widest">Search Results</h1>
            <p class="text-lg max-w-xl">Available rooms for your dates in Limpopo.</p>
            <div class="mt-4">
                @include('public.partials.booking-steps', ['current' => 'choose'])
            </div>
        </div>
    </section>

    <section class="py-12 bg-white">
        <div class="container grid gap-8 lg:grid-cols-[280px,1fr]">
            <aside class="bg-neutral-100 p-5 rounded-xl">
                <h3 class="text-lg font-semibold mb-3">Your Details</h3>
                <div class="space-y-2 text-sm">
                    <p><strong>Check-in:</strong> {{ $search['check_in'] }}</p>
                    <p><strong>Check-out:</strong> {{ $search['check_out'] }}</p>
                    <p><strong>Adults:</strong> {{ $search['adults'] }}</p>
                    <p><strong>Children:</strong> {{ $search['children'] ?? 0 }}</p>
                </div>
                <a href="{{ route('home') }}#booking" class="inline-flex items-center justify-center gap-2 rounded-full px-4 py-2.5 font-semibold border border-black text-black bg-transparent transition mt-4">Change Dates</a>
            </aside>

            <div class="grid gap-6 md:grid-cols-2">
                @forelse($rooms as $room)
                    <x-room-card :room="$room" :search="$search" />
                @empty
                    <div class="bg-neutral-100 p-6 rounded-xl">
                        <p>No rooms matched your search. Please adjust your dates.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
