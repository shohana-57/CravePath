@extends('layouts.app')

@section('title', 'Explore Food Spots')

@section('content')
<h4 class="mb-3">Explore Food Spots</h4>

{{-- Search & Filter --}}
<form method="GET" action="{{ route('spots.index') }}" class="row g-2 mb-4">
    <div class="col-md-3">
        <input type="text" name="search" class="form-control" placeholder="Search by name..." value="{{ request('search') }}">
    </div>
    <div class="col-md-3">
        <input type="text" name="area" class="form-control" placeholder="Area (e.g. Dhanmondi)" value="{{ request('area') }}">
    </div>
    <div class="col-md-2">
        <select name="category_id" class="form-select">
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <select name="price_range" class="form-select">
            <option value="">All Prices</option>
            <option value="budget" {{ request('price_range') == 'budget' ? 'selected' : '' }}>Budget</option>
            <option value="mid" {{ request('price_range') == 'mid' ? 'selected' : '' }}>Mid</option>
            <option value="premium" {{ request('price_range') == 'premium' ? 'selected' : '' }}>Premium</option>
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-warning w-100">Search</button>
    </div>
</form>

{{-- Food Spots Grid --}}
@if($spots->isEmpty())
    <div class="alert alert-info">No food spots found. Try a different search!</div>
@else
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($spots as $spot)
            <div class="col">
                <div class="card h-100 spot-card">
                    @if($spot->photos->first())
                        <img src="{{ asset('storage/'.$spot->photos->first()->path) }}" class="card-img-top" style="height:180px; object-fit:cover;">
                    @else
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height:180px;">
                            <span>No Photo</span>
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $spot->name }}</h5>
                        <p class="text-muted mb-1"><i class="bi bi-geo-alt"></i> {{ $spot->area }}</p>
                        <p class="text-muted mb-1"><i class="bi bi-tag"></i> {{ ucfirst($spot->price_range) }}</p>
                        <p class="text-muted mb-2"><i class="bi bi-star-fill text-warning"></i> {{ number_format($spot->avg_rating, 1) }} ({{ $spot->review_count }} reviews)</p>
                        @if($spot->category)
                            <span class="badge bg-warning text-dark">{{ $spot->category->name }}</span>
                        @endif
                    </div>
                    <div class="card-footer bg-white">
                        <a href="{{ route('spots.show', $spot->id) }}" class="btn btn-outline-warning w-100">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection