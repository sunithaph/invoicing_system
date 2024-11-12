@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>
    
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        
        @if(Auth::user()->is_admin)
            <div class="form-group">
                <label for="is_admin">Role</label>
                <select name="is_admin" class="form-control">
                    <option value="0" {{ $user->is_admin ? '' : 'selected' }}>User</option>
                    <option value="1" {{ $user->is_admin ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
        @endif
        
        <button type="submit" class="btn btn-primary mt-3">Update User</button>
    </form>
</div>
@endsection
