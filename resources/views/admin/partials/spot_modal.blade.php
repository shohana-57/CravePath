<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">{{ $foodSpot->name }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        @if($foodSpot->photos->count())
            <div class="mb-3">
                <div class="row g-2">
                    @foreach($foodSpot->photos as $photo)
                        <div class="col-4">
                            <img src="{{ asset('storage/'.$photo->path) }}" data-full="{{ asset('storage/'.$photo->path) }}" class="img-fluid rounded spot-photo-thumb" style="height:80px;object-fit:cover;width:100%">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <p class="text-muted">{{ $foodSpot->description }}</p>

        <p class="small text-muted">Seller: {{ $foodSpot->seller->name }}</p>
        <p class="small text-muted"><i class="bi bi-geo-alt"></i> {{ $foodSpot->area }} @if($foodSpot->address) — {{ $foodSpot->address }}@endif</p>

        @if($weather)
            <div class="weather-card mb-2 p-2 weather-block" data-spot-id="{{ $foodSpot->id }}">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong class="weather-temp">{{ $weather['temperature'] }}°C</strong>
                        <div class="small text-capitalize weather-desc">{{ $weather['description'] }}</div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <img class="weather-icon" src="https://openweathermap.org/img/wn/{{ $weather['icon'] }}@2x.png" width="48">
                        <button class="btn btn-sm btn-outline-secondary refresh-weather" data-spot-id="{{ $foodSpot->id }}">Refresh</button>
                    </div>
                </div>
            </div>
        @endif

        <hr>
        <h6 class="mb-2">Recent Reviews</h6>
        @forelse($foodSpot->reviews as $review)
            <div class="mb-2">
                <strong>{{ $review->user?->name }}</strong>
                <div class="small text-muted">{{ str_repeat('⭐', $review->rating) }} — {{ $review->created_at->diffForHumans() }}</div>
                @if($review->remarks)
                    <div class="mt-1">{{ $review->remarks }}</div>
                @endif
            </div>
        @empty
            <div class="text-muted small">No reviews yet.</div>
        @endforelse
    </div>
    <div class="modal-footer">
        <form method="POST" action="{{ route('admin.spots.approve', $foodSpot->id) }}">
            @csrf
            <button class="btn btn-success">Approve</button>
        </form>
        <form method="POST" action="{{ route('admin.spots.delete', $foodSpot->id) }}">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" onclick="return confirm('Delete this spot?')">Delete</button>
        </form>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
</div>
