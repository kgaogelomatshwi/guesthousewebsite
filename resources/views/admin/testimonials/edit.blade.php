@extends('admin.layouts.app')

@section('content')
    <h1>Edit Testimonial</h1>
    <form class="form" method="post" action="{{ route('admin.testimonials.update', $testimonial) }}">
        @csrf
        @method('PUT')
        <div class="form-row">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $testimonial->name) }}" required>
        </div>
        <div class="form-row">
            <label>Rating</label>
            <input type="number" min="1" max="5" name="rating" value="{{ old('rating', $testimonial->rating) }}">
        </div>
        <div class="form-row">
            <label>Comment</label>
            <textarea name="comment" rows="4">{{ old('comment', $testimonial->comment) }}</textarea>
        </div>
        <div class="form-row">
            <label>Date</label>
            <input type="date" name="date" value="{{ old('date', $testimonial->date) }}">
        </div>
        <div class="form-row">
            <label>Published</label>
            <select name="is_published">
                <option value="1" @selected($testimonial->is_published)>Yes</option>
                <option value="0" @selected(! $testimonial->is_published)>No</option>
            </select>
        </div>
        <button class="btn btn-primary" type="submit">Save</button>
    </form>
@endsection
