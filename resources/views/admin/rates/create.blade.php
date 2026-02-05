@extends('admin.layouts.app')

@section('content')
    <h1>Add Rate</h1>
    <form class="form" method="post" action="{{ route('admin.rates.store') }}">
        @csrf
        <div class="form-row">
            <label>Title</label>
            <input type="text" name="title" value="{{ old('title') }}" required>
        </div>
        <div class="form-row">
            <label>Description</label>
            <textarea name="description" rows="3">{{ old('description') }}</textarea>
        </div>
        <div class="grid-2">
            <div class="form-row">
                <label>Price</label>
                <input type="number" step="0.01" name="price" value="{{ old('price') }}">
            </div>
            <div class="form-row">
                <label>Notes</label>
                <input type="text" name="notes" value="{{ old('notes') }}">
            </div>
        </div>
        <div class="grid-2">
            <div class="form-row">
                <label>Season Start</label>
                <input type="date" name="season_start" value="{{ old('season_start') }}">
            </div>
            <div class="form-row">
                <label>Season End</label>
                <input type="date" name="season_end" value="{{ old('season_end') }}">
            </div>
        </div>
        <div class="form-row">
            <label>Active</label>
            <select name="is_active">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
        <button class="btn btn-primary" type="submit">Create</button>
    </form>
@endsection
