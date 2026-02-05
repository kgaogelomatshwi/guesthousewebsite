@extends('admin.layouts.app')

@section('content')
    <h1>Add Testimonial</h1>
    <form class="form" method="post" action="{{ route('admin.testimonials.store') }}">
        @csrf
        <div class="form-row">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>
        <div class="form-row">
            <label>Rating</label>
            <input type="number" min="1" max="5" name="rating" value="{{ old('rating', 5) }}">
        </div>
        <div class="form-row">
            <label>Comment</label>
            <textarea name="comment" rows="4">{{ old('comment') }}</textarea>
        </div>
        <div class="form-row">
            <label>Date</label>
            <input type="date" name="date" value="{{ old('date') }}">
        </div>
        <div class="form-row">
            <label>Published</label>
            <select name="is_published">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
        <button class="btn btn-primary" type="submit">Create</button>
    </form>
@endsection
