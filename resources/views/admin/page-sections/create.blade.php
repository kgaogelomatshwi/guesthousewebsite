@extends('admin.layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold">Add Section to {{ $page->title }}</h1>
    <form class="grid gap-4 mt-4" method="post" action="{{ route('admin.pages.sections.store') }}">
        @csrf
        <input type="hidden" name="page_id" value="{{ $page->id }}">
        @include('admin.page-sections.form', ['section' => new \App\Models\PageSection()])
        <button class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent transition bg-black text-white shadow-lg" type="submit">Create Section</button>
    </form>
@endsection
