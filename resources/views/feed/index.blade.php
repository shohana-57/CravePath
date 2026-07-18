@extends('layouts.app')

@section('title', 'Food Lover Feed')

@section('content')

<div class="page-header">
    <div class="container">
        <h2 class="mb-1"><i class="bi bi-newspaper"></i> Food Lover Feed</h2>
        <p class="mb-0 opacity-75">Browse approved shops like a social feed and share visited places for others.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        @forelse($spots as $spot)
            <div class="card spot-card mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="mb-1">{{ $spot->name }}</h5>
                            <small class="text-muted">{{ $spot->category?->name }} • {{ ucfirst($spot->price_range) }}</small>
                        </div>
                        <span class="badge badge-{{ $spot->price_range }}">{{ ucfirst($spot->price_range) }}</span>
                    </div>
                    @if($spot->photos->first())
                        <img src="{{ asset('storage/'.$spot->photos->first()->path) }}" data-full="{{ asset('storage/'.$spot->photos->first()->path) }}" class="img-fluid rounded mb-3 spot-photo-thumb" style="max-height: 350px; width: 100%; object-fit: cover;">
                    @endif
                    <p>{{ Str::limit($spot->description, 180) }}</p>
                    <div class="d-flex flex-wrap gap-2 align-items-center text-muted small mb-3">
                        <span><i class="bi bi-geo-alt"></i> {{ $spot->area }}</span>
                        <span><i class="bi bi-star-fill text-warning"></i> {{ number_format($spot->avg_rating, 1) }} ({{ $spot->review_count }})</span>
                        <span>Posted by {{ $spot->seller->name }}</span>
                    </div>
                    @if(isset($weatherBySpot[$spot->id]) && $weatherBySpot[$spot->id])
                        <div class="d-flex align-items-center justify-content-between mb-3 p-3 bg-light rounded-3 border weather-block" data-spot-id="{{ $spot->id }}">
                            <div>
                                <div class="small text-muted">Weather</div>
                                <strong class="weather-temp">{{ $weatherBySpot[$spot->id]['temperature'] }}°C</strong>
                                <div class="small text-capitalize weather-desc">{{ $weatherBySpot[$spot->id]['description'] }}</div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <img class="weather-icon" src="https://openweathermap.org/img/wn/{{ $weatherBySpot[$spot->id]['icon'] }}@2x.png" width="48" alt="weather">
                                <button class="btn btn-sm btn-outline-secondary refresh-weather" data-spot-id="{{ $spot->id }}">Refresh</button>
                            </div>
                        </div>
                    @endif
                    <a href="{{ route('spots.show', $spot->id) }}" class="btn btn-primary-cp btn-sm">View post</a>
                </div>
            </div>
        @empty
            <div class="alert alert-info">No approved spots yet.</div>
        @endforelse
    </div>

    <div class="col-lg-4">
        <div class="card spot-card p-4 mb-4">
            <h5 class="fw-700 mb-3"><i class="bi bi-map-pin"></i> Share a Visited Shop</h5>
            @auth
                <form method="POST" action="{{ route('visited-spots.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Shop name</label>
                        <input type="text" name="shop_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Area</label>
                        <input type="text" name="area" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes for others</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Photo</label>
                        <input type="file" name="photo" class="form-control" accept="image/*">
                    </div>
                    <button class="btn btn-primary-cp w-100">Share visited shop</button>
                </form>
            @else
                <div class="text-center text-muted">
                    <p class="mb-2">Login to share your visited shop.</p>
                    <a href="{{ route('login') }}" class="btn btn-outline-cp btn-sm">Login</a>
                </div>
            @endauth
        </div>

        <div class="card spot-card p-4">
            <h5 class="fw-700 mb-3"><i class="bi bi-heart"></i> Recently Visited</h5>
            @forelse($visitedSpots as $visited)
                <div class="mb-4">
                    @if($visited->photo_path)
                        <img src="{{ asset('storage/'.$visited->photo_path) }}" data-full="{{ asset('storage/'.$visited->photo_path) }}" class="img-fluid rounded mb-2 spot-photo-thumb" style="height: 180px; object-fit: cover; width: 100%;">
                    @endif
                    <h6 class="mb-1">{{ $visited->shop_name }}</h6>
                    <div class="small text-muted">{{ $visited->area }}</div>
                    <p class="small mt-2">{{ Str::limit($visited->notes, 100) }}</p>
                    <small class="text-muted">Shared by {{ $visited->user->name }}</small>
                </div>
            @empty
                <div class="text-muted small">No visited shop posts yet. Share one!</div>
            @endforelse
        </div>
    </div>
</div>

@endsection
