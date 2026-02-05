@extends('admin.layouts.app')

@section('content')
    <div class="flex-between">
        <h1>Testimonials</h1>
        <a class="btn btn-primary" href="{{ route('admin.testimonials.create') }}">Add Testimonial</a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Rating</th>
            <th>Status</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($testimonials as $testimonial)
            <tr>
                <td>{{ $testimonial->name }}</td>
                <td>{{ $testimonial->rating }}</td>
                <td>{{ $testimonial->is_published ? 'Published' : 'Hidden' }}</td>
                <td>
                    <a class="btn btn-outline" href="{{ route('admin.testimonials.edit', $testimonial) }}">Edit</a>
                    <form method="post" action="{{ route('admin.testimonials.destroy', $testimonial) }}" class="inline">
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
