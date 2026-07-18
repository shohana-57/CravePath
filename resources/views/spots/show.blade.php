@extends('layouts.app')

@section('title', $foodSpot->name)

@section('content')

<div class="page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('spots.index') }}" class="text-white opacity-75">Explore</a></li>
                <li class="breadcrumb-item active text-white">{{ $foodSpot->name }}</li>
            </ol>
        </nav>
        <h2 class="mb-1">{{ $foodSpot->name }}</h2>
        <p class="mb-0 opacity-75">
            <i class="bi bi-geo-alt-fill"></i> {{ $foodSpot->area }}
            @if($foodSpot->address) — {{ $foodSpot->address }} @endif
        </p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        @if($foodSpot->photos->count())
            <div class="card spot-card mb-4">
                <div class="card-body p-3">
                    <div class="row g-2">
                        @foreach($foodSpot->photos as $photo)
                            <div class="col-4">
                                <img src="{{ asset('storage/'.$photo->path) }}" data-full="{{ asset('storage/'.$photo->path) }}" class="img-fluid rounded spot-photo-thumb" style="height:140px; object-fit:cover; width:100%;">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <div class="card spot-card mb-4">
            <div class="card-body p-4">
                <div class="d-flex gap-2 flex-wrap mb-3">
                    <span class="badge badge-{{ $foodSpot->price_range }} px-3 py-2">{{ ucfirst($foodSpot->price_range) }}</span>
                    @if($foodSpot->category)
                        <span class="badge bg-warning text-dark px-3 py-2">{{ $foodSpot->category->name }}</span>
                    @endif
                    <span class="badge bg-light text-dark px-3 py-2">
                        <i class="bi bi-star-fill text-warning"></i> {{ number_format($foodSpot->avg_rating, 1) }} ({{ $foodSpot->review_count }} reviews)
                    </span>
                </div>
                @if($foodSpot->description)
                    <p class="text-muted">{{ $foodSpot->description }}</p>
                @endif
                @if($weather)
                    <div class="weather-card mb-4 weather-block" data-spot-id="{{ $foodSpot->id }}">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h6 class="mb-1 opacity-75"><i class="bi bi-cloud-sun"></i> Weather in {{ $weather['city'] }}</h6>
                                <h2 class="mb-0 fw-700 weather-temp">{{ $weather['temperature'] }}°C</h2>
                                <p class="mb-0 text-capitalize opacity-75 weather-desc">{{ $weather['description'] }}</p>
                            </div>
                            <div class="col-4 text-end d-flex align-items-center justify-content-end gap-2">
                                <img class="weather-icon" src="https://openweathermap.org/img/wn/{{ $weather['icon'] }}@2x.png" width="60" alt="weather icon">
                                <button class="btn btn-sm btn-outline-secondary refresh-weather" data-spot-id="{{ $foodSpot->id }}">Refresh</button>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6"><small class="opacity-75">Humidity</small><div class="fw-600 weather-humidity">{{ $weather['humidity'] }}%</div></div>
                            <div class="col-6"><small class="opacity-75">Wind</small><div class="fw-600 weather-wind">{{ $weather['wind'] }} km/h</div></div>
                        </div>
                    </div>
                @else
                    <div class="weather-card mb-4 weather-block">
                        <div class="p-4 text-center text-muted">
                            <i class="bi bi-cloud-slash fs-2 mb-2"></i>
                            <p class="mb-0">Weather unavailable for {{ $foodSpot->area ?? 'this location' }}.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @if($foodSpot->menuItems->count())
            <div class="card spot-card mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-700 mb-3"><i class="bi bi-menu-button-wide text-warning"></i> Menu</h5>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead><tr><th>Item</th><th class="text-end">Price (BDT)</th></tr></thead>
                            <tbody>
                                @foreach($foodSpot->menuItems as $item)
                                    <tr><td>{{ $item->name }}</td><td class="text-end fw-600">৳ {{ number_format($item->price, 2) }}</td></tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        @if($foodSpot->video_url)
            <div class="card spot-card mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-700 mb-3"><i class="bi bi-play-circle text-warning"></i> Video</h5>
                    <a href="{{ $foodSpot->video_url }}" target="_blank" class="btn btn-outline-cp">Watch promo / menu video</a>
                </div>
            </div>
        @endif

        <div class="card spot-card mb-4">
            <div class="card-body p-4">
                <h5 class="fw-700 mb-3"><i class="bi bi-chat-square-text text-warning"></i> Reviews</h5>
                @auth
                    @if(auth()->user()->role === 'food_lover')
                        <form method="POST" action="{{ route('reviews.store', $foodSpot->id) }}" class="mb-4 p-3 bg-light rounded-3">
                            @csrf
                            <h6 class="mb-3">Write a Review</h6>
                            <div class="mb-3">
                                <label class="form-label small fw-600">Rating</label>
                                <select name="rating" class="form-select w-auto" required>
                                    <option value="">Select rating</option>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}">{{ str_repeat('⭐', $i) }} {{ $i }}/5</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-600">Your Review</label>
                                <textarea name="remarks" class="form-control" rows="3" placeholder="Share your experience..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary-cp btn-sm"><i class="bi bi-send"></i> Submit Review</button>
                        </form>
                    @endif
                @endauth

                @forelse($foodSpot->reviews as $review)
                    <div class="card border-0 bg-light rounded-3 mb-3">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div><strong>{{ $review->user->name }}</strong><span class="ms-2">{{ str_repeat('⭐', $review->rating) }}</span></div>
                                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                            </div>
                            @if($review->remarks)
                                <p class="mt-2 mb-2 text-muted">{{ $review->remarks }}</p>
                            @endif
                            @if($review->seller_reply)
                                <div class="bg-white p-2 rounded-2 mt-2 border-start border-warning border-3">
                                    <small><i class="bi bi-shop text-warning"></i> <strong>Seller reply:</strong> {{ $review->seller_reply }}</small>
                                </div>
                            @endif
                            @auth
                                @if(auth()->user()->role === 'seller' && $foodSpot->user_id === auth()->id() && !$review->seller_reply)
                                    <form method="POST" action="{{ route('reviews.reply', $review->id) }}" class="mt-2 d-flex gap-2">
                                        @csrf
                                        <input type="text" name="seller_reply" class="form-control form-control-sm" placeholder="Write a reply...">
                                        <button type="submit" class="btn btn-sm btn-outline-cp text-nowrap">Reply</button>
                                    </form>
                                @endif
                                @if(!$review->is_flagged && auth()->user()->role === 'food_lover')
                                    <form method="POST" action="{{ route('reviews.flag', $review->id) }}" class="mt-1">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-link text-danger p-0"><i class="bi bi-flag"></i> Report</button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted"><i class="bi bi-chat-dots fs-2 d-block mb-2"></i>No reviews yet. Be the first to review!</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-4">
        @if($weather)
            <div class="weather-card mb-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="mb-1 opacity-75"><i class="bi bi-cloud-sun"></i> Weather in {{ $weather['city'] }}</h6>
                        <h2 class="mb-0 fw-700">{{ $weather['temperature'] }}°C</h2>
                        <p class="mb-0 text-capitalize opacity-75">{{ $weather['description'] }}</p>
                    </div>
                    <img src="https://openweathermap.org/img/wn/{{ $weather['icon'] }}@2x.png" width="60" alt="weather icon">
                </div>
                <hr class="border-white opacity-25">
                <div class="row text-center">
                    <div class="col-6"><small class="opacity-75">Humidity</small><div class="fw-600">{{ $weather['humidity'] }}%</div></div>
                    <div class="col-6"><small class="opacity-75">Wind</small><div class="fw-600">{{ $weather['wind'] }} km/h</div></div>
                </div>
            </div>
        @else
            <div class="weather-card mb-4">
                <div class="p-4 text-center text-muted">
                    <i class="bi bi-cloud-slash fs-2 mb-2"></i>
                    <p class="mb-0">Weather unavailable for {{ $foodSpot->area ?? 'this location' }}.</p>
                </div>
            </div>
        @endif

        <div class="card spot-card mb-4">
            <div class="card-body p-4">
                <h6 class="fw-700 mb-3"><i class="bi bi-shop text-warning"></i> Seller Info</h6>
                <p class="mb-1"><strong>{{ $foodSpot->seller->name }}</strong></p>
                <small class="text-muted">Verified Seller</small>
            </div>
        </div>

        <div class="card spot-card mb-4">
            <div class="card-body p-4">
                <h6 class="fw-700 mb-3"><i class="bi bi-telephone text-warning"></i> Contact</h6>
                @if($foodSpot->contact_number)<p class="mb-1"><i class="bi bi-phone"></i> {{ $foodSpot->contact_number }}</p>@endif
                @if($foodSpot->contact_email)<p class="mb-1"><i class="bi bi-envelope"></i> {{ $foodSpot->contact_email }}</p>@endif
                @if($foodSpot->opening_hours)<p class="mb-1"><i class="bi bi-clock"></i> {{ $foodSpot->opening_hours }}</p>@endif
            </div>
        </div>

        <div class="card spot-card">
            <div class="card-body p-4">
                <h6 class="fw-700 mb-3"><i class="bi bi-geo-alt text-warning"></i> Location</h6>
                <p class="text-muted mb-1">{{ $foodSpot->area }}</p>
                @if($foodSpot->address)<p class="text-muted small">{{ $foodSpot->address }}</p>@endif
                @auth
                    @if(auth()->user()->role === 'food_lover')
                        <form method="POST" action="{{ route('visit-requests.store', $foodSpot->id) }}" class="mt-3">
                            @csrf
                            <label class="form-label small fw-600">Request a visit</label>
                            <div class="mb-2">
                                <select name="purpose" class="form-select form-select-sm">
                                    <option value="">Select purpose (optional)</option>
                                    <option value="casual_visit">Casual visit</option>
                                    <option value="photoshoot">Photoshoot</option>
                                    <option value="event_booking">Event / Booking</option>
                                    <option value="collaboration">Collaboration</option>
                                </select>
                            </div>
                            <textarea name="message" class="form-control" rows="3" placeholder="Additional details or preferred time..."></textarea>
                            <button type="submit" class="btn btn-primary-cp btn-sm mt-2"><i class="bi bi-send"></i> Share Request</button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>

@endsection