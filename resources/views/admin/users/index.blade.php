@extends('admin.layouts.app')

@section('content')
    <div class="flex-between">
        <h1>Users</h1>
        <a class="btn btn-primary" href="{{ route('admin.users.create') }}">Add User</a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Roles</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->roles->pluck('name')->implode(', ') }}</td>
                <td>
                    <a class="btn btn-outline" href="{{ route('admin.users.edit', $user) }}">Edit</a>
                    <form method="post" action="{{ route('admin.users.destroy', $user) }}" class="inline">
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
