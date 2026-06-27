@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="card p-4">
        <h3>Welcome, {{ auth()->user()->name }} </h3>
        <p class="text-muted">You're logged in as: <strong>{{ auth()->user()->role }}</strong></p>

        @if(auth()->user()->role === 'seller')
            <a href="{{ route('seller.dashboard') }}" class="btn btn-warning">Go to My Spots</a>
        @elseif(auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="btn btn-warning">Go to Admin Panel</a>
        @else
            <a href="{{ route('spots.index') }}" class="btn btn-warning">Explore Food Spots</a>
        @endif
    </div>
@endsection