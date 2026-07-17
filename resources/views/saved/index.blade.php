@extends('layouts.app')

@section('title', 'Saved Spots')

@section('content')
<h4 class="mb-4">My Saved Spots</h4>

@if($saved->isEmpty())
    <div class="alert alert-info">You haven't saved any spots yet. <a href="{{ route('spots.index') }}">Explore now!</a></div>
@else
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($saved as $item)
            <div class="col">
                <div class="card h-100 spot-card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->foodSpot->name }}</h5>
                        <p class="text-muted"><i class="bi bi-geo-alt"></i> {{ $item->foodSpot->area }}</p>
                        <p class="text-muted"><i class="bi bi-tag"></i> {{ ucfirst($item->foodSpot->price_range) }}</p>
                        <p><i class="bi bi-star-fill text-warning"></i> {{ number_format($item->foodSpot->avg_rating, 1) }}</p>
                    </div>
                    <div class="card-footer bg-white d-flex gap-2">
                        <a href="{{ route('spots.show', $item->foodSpot->id) }}" class="btn btn-outline-warning btn-sm flex-fill">View</a>
                        <form method="POST" action="{{ route('saved.destroy', $item->foodSpot->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm">Remove</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection