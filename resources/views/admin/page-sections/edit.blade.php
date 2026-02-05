@extends('admin.layouts.app')

@section('content')
    <h1>Edit Section</h1>
    <form class="form" method="post" action="{{ route('admin.pages.sections.update', [$page, $section]) }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="page_id" value="{{ $page->id }}">
        @include('admin.page-sections.form', ['section' => $section])
        <button class="btn btn-primary" type="submit">Save Section</button>
    </form>
@endsection
