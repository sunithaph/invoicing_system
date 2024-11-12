@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User Details</h1>
    
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Name: {{ $user->name }}</h5>
            <p class="card-text">Email: {{ $user->email }}</p>
            <p class="card-text">Role: {{ $user->is_admin ? 'Admin' : 'User' }}</p>
        </div>
    </div>
    @if(auth()->user()->is_admin)
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to Users</a>
    @else
        <a href="{{ route('users.edit', auth()->user()->id) }}" class="btn btn-primary">Edit Profile</a>
    @endif
</div>
@endsection
