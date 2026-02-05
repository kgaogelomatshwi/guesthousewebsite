@extends('admin.layouts.app')

@section('content')
    <div class="flex-between">
        <h1>Rates</h1>
        <a class="btn btn-primary" href="{{ route('admin.rates.create') }}">Add Rate</a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Title</th>
            <th>Price</th>
            <th>Season</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($rates as $rate)
            <tr>
                <td>{{ $rate->title }}</td>
                <td>{{ $rate->price }}</td>
                <td>{{ $rate->season_start }} - {{ $rate->season_end }}</td>
                <td>
                    <a class="btn btn-outline" href="{{ route('admin.rates.edit', $rate) }}">Edit</a>
                    <form method="post" action="{{ route('admin.rates.destroy', $rate) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-ghost" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
