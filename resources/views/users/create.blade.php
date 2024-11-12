@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New User</h1>
    
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="is_admin">Role</label>
            <select name="is_admin" class="form-control">
                <option value="0">User</option>
                <option value="1">Admin</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary mt-3">Create User</button>
    </form>
</div>
@endsection
