@extends('layouts.app')

@section('title', 'Saved Spots')

@section('content')

<div class="page-header">
    <div class="container">
        <h2 class="mb-1"><i class="bi bi-bookmark-heart"></i> My Saved Spots</h2>
        <p class="mb-0 opacity-75">Food spots you've bookmarked</p>
    </div>
</div>

@if($saved->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-bookmark fs-1 text-muted d-block mb-3"></i>
        <h5 class="text-muted">No saved spots yet</h5>
        <p class="text-muted">Explore food spots and save your favorites!</p>
        <a href="{{ route('spots.index') }}" class="btn btn-primary-cp">
            <i class="bi bi-compass"></i> Explore Now
        </a>
    </div>
@else
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($saved as $item)
            <div class="col">
                @if($item->foodSpot)
                    <div class="card spot-card h-100">
                        @if($item->foodSpot->photos->first())
                            <img src="{{ asset('storage/'.$item->foodSpot->photos->first()->path) }}" data-full="{{ asset('storage/'.$item->foodSpot->photos->first()->path) }}"
                                class="card-img-top spot-photo-thumb" style="height:190px; object-fit:cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light" style="height:190px;">
                                <i class="bi bi-image text-muted fs-1"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->foodSpot->name }}</h5>
                            <p class="text-muted small mb-1">
                                <i class="bi bi-geo-alt-fill text-danger"></i> {{ $item->foodSpot->area }}
                            </p>
                            <p class="text-muted small mb-2">
                                <i class="bi bi-star-fill text-warning"></i>
                                {{ number_format($item->foodSpot->avg_rating, 1) }}
                                ({{ $item->foodSpot->review_count }} reviews)
                            </p>
                            <span class="badge badge-{{ $item->foodSpot->price_range }}">
                                {{ ucfirst($item->foodSpot->price_range) }}
                            </span>
                        </div>
                        <div class="card-footer bg-white border-0 pb-3 d-flex gap-2">
                            <a href="{{ route('spots.show', $item->foodSpot->id) }}"
                                class="btn btn-outline-cp btn-sm flex-fill">View</a>
                            <form method="POST" action="{{ route('saved.destroy', $item->foodSpot->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger rounded-pill">
                                    <i class="bi bi-bookmark-x"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="card spot-card h-100 p-4 text-center text-muted">
                        This saved spot was removed.
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endif

@endsection