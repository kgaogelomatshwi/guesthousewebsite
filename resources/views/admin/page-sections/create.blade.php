@extends('admin.layouts.app')

@section('content')
    <h1>Add Section to {{ $page->title }}</h1>
    <form class="form" method="post" action="{{ route('admin.pages.sections.store') }}">
        @csrf
        <input type="hidden" name="page_id" value="{{ $page->id }}">
        @include('admin.page-sections.form', ['section' => new \App\Models\PageSection()])
        <button class="btn btn-primary" type="submit">Create Section</button>
    </form>
@endsection
