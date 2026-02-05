@extends('admin.layouts.app')

@section('content')
    <div class="flex-between">
        <h1>Enquiries</h1>
        <a class="btn btn-outline" href="{{ route('admin.enquiries.export') }}">Export CSV</a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Dates</th>
            <th>Status</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($enquiries as $enquiry)
            <tr>
                <td>{{ $enquiry->name }}</td>
                <td>{{ $enquiry->email }}</td>
                <td>{{ $enquiry->check_in }} - {{ $enquiry->check_out }}</td>
                <td>{{ $enquiry->status }}</td>
                <td><a class="btn btn-outline" href="{{ route('admin.enquiries.show', $enquiry) }}">View</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $enquiries->links() }}
@endsection
