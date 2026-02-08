@extends('admin.layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold">Edit Section</h1>
    <form class="grid gap-4 mt-4" method="post" action="{{ route('admin.pages.sections.update', [$page, $section]) }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="page_id" value="{{ $page->id }}">
        @include('admin.page-sections.form', ['section' => $section])
        <button class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent transition bg-black text-white shadow-lg" type="submit">Save Section</button>
    </form>
@endsection
