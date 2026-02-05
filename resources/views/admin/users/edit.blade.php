@extends('admin.layouts.app')

@section('content')
    <h1>Edit User</h1>
    <form class="form" method="post" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')
        <div class="grid-2">
            <div class="form-row">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="form-row">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>
        </div>
        <div class="grid-2">
            <div class="form-row">
                <label>Password (leave blank to keep)</label>
                <input type="password" name="password">
            </div>
            <div class="form-row">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation">
            </div>
        </div>
        <div class="form-row">
            <label>Roles</label>
            <div class="checkbox-grid">
                @foreach($roles as $role)
                    <label class="checkbox">
                        <input type="checkbox" name="roles[]" value="{{ $role->id }}" @checked($user->roles->contains($role->id))>
                        {{ $role->name }}
                    </label>
                @endforeach
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Save</button>
    </form>
@endsection
