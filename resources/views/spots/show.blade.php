@extends('layouts.app')

@section('title', $foodSpot->name)

@section('content')
<div class="row">
    <div class="col-md-8">
        <h3>{{ $foodSpot->name }}</h3>
        <p class="text-muted">
            <i class="bi bi-geo-alt"></i> {{ $foodSpot->area }}
            @if($foodSpot->address) — {{ $foodSpot->address }} @endif
        </p>
        <p><span class="badge bg-warning text-dark">{{ ucfirst($foodSpot->price_range) }}</span>
        @if($foodSpot->category)
            <span class="badge bg-secondary">{{ $foodSpot->category->name }}</span>
        @endif</p>
        <p>{{ $foodSpot->description }}</p>
        <p><i class="bi bi-star-fill text-warning"></i> {{ number_format($foodSpot->avg_rating, 1) }} ({{ $foodSpot->review_count }} reviews)</p>

        {{-- Save button --}}
        @auth
            @if(auth()->user()->role === 'food_lover')
                <form method="POST" action="{{ route('saved.store', $foodSpot->id) }}" class="d-inline">
                    @csrf
                    <button class="btn btn-outline-warning btn-sm mb-3">
                        <i class="bi bi-bookmark"></i> Save Spot
                    </button>
                </form>
            @endif
        @endauth

        {{-- Photos --}}
        @if($foodSpot->photos->count())
            <h5 class="mt-3">Photos</h5>
            <div class="row g-2 mb-3">
                @foreach($foodSpot->photos as $photo)
                    <div class="col-4">
                        <img src="{{ asset('storage/'.$photo->path) }}" class="img-fluid rounded" style="height:120px; object-fit:cover; width:100%;">
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Menu Items --}}
        @if($foodSpot->menuItems->count())
            <h5>Menu</h5>
            <table class="table table-bordered mb-4">
                <thead class="table-warning">
                    <tr><th>Item</th><th>Price (BDT)</th></tr>
                </thead>
                <tbody>
                    @foreach($foodSpot->menuItems as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ number_format($item->price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        {{-- Reviews --}}
        <h5>Reviews</h5>

        @auth
            @if(auth()->user()->role === 'food_lover')
                <form method="POST" action="{{ route('reviews.store', $foodSpot->id) }}" class="mb-4">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label">Rating</label>
                        <select name="rating" class="form-select w-auto" required>
                            <option value="">Select</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }} ⭐</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Your Review</label>
                        <textarea name="remarks" class="form-control" rows="3" placeholder="Write your experience..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-warning">Submit Review</button>
                </form>
            @endif
        @endauth

        @forelse($foodSpot->reviews as $review)
            <div class="card mb-3">
                <div class="card-body">
                    <strong>{{ $review->user->name }}</strong>
                    <span class="text-warning ms-2">{{ str_repeat('⭐', $review->rating) }}</span>
                    <p class="mb-1 mt-1">{{ $review->remarks }}</p>

                    @if($review->seller_reply)
                        <div class="bg-light p-2 rounded mt-2">
                            <small><strong>Seller reply:</strong> {{ $review->seller_reply }}</small>
                        </div>
                    @endif

                    {{-- Seller reply form --}}
                    @auth
                        @if(auth()->user()->role === 'seller' && $foodSpot->user_id === auth()->id() && !$review->seller_reply)
                            <form method="POST" action="{{ route('reviews.reply', $review->id) }}" class="mt-2">
                                @csrf
                                <input type="text" name="seller_reply" class="form-control form-control-sm mb-1" placeholder="Write a reply...">
                                <button type="submit" class="btn btn-sm btn-outline-secondary">Reply</button>
                            </form>
                        @endif

                        {{-- Flag review --}}
                        @if(!$review->is_flagged && auth()->user()->role === 'food_lover')
                            <form method="POST" action="{{ route('reviews.flag', $review->id) }}" class="mt-1">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger">Report</button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        @empty
            <p class="text-muted">No reviews yet. Be the first to review!</p>
        @endforelse
    </div>

    <div class="col-md-4">
        <div class="card p-3">
            <h6>Seller Info</h6>
            <p class="mb-0">{{ $foodSpot->seller->name }}</p>
        </div>
    </div>
</div>
@endsection