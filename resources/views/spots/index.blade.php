@extends('layouts.app')

@section('title', 'Explore Food Spots')

@section('content')

<div class="page-header">
    <div class="container">
        <h2 class="mb-1">🍽️ Explore Food Spots</h2>
        <p class="mb-0 opacity-75">Discover the best street food & restaurants near you</p>
        @if(isset($lastSearchedArea) && $lastSearchedArea)
            <small class="opacity-75"><i class="bi bi-clock-history"></i> Last searched: <strong>{{ $lastSearchedArea }}</strong></small>
        @endif
    </div>
</div>

{{-- Search Bar --}}
<div class="search-bar">
    <div class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label fw-600 small text-muted">Search by name</label>
            <input type="text" id="search" class="form-control" placeholder="e.g. Fuchka, Biryani..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label fw-600 small text-muted">Area</label>
            <input type="text" id="area" class="form-control" placeholder="e.g. Dhanmondi, Khulna" value="{{ request('area', $lastSearchedArea ?? '') }}">
        </div>
        <div class="col-md-2">
            <label class="form-label fw-600 small text-muted">Category</label>
            <select id="category_id" class="form-select">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label fw-600 small text-muted">Price</label>
            <select id="price_range" class="form-select">
                <option value="">All Prices</option>
                <option value="budget" {{ request('price_range') == 'budget' ? 'selected' : '' }}>💚 Budget</option>
                <option value="mid" {{ request('price_range') == 'mid' ? 'selected' : '' }}>💛 Mid</option>
                <option value="premium" {{ request('price_range') == 'premium' ? 'selected' : '' }}>❤️ Premium</option>
            </select>
        </div>
        <div class="col-md-2">
            <button id="ajax-search-btn" class="btn btn-primary-cp w-100">
                <i class="bi bi-search"></i> Search
            </button>
        </div>
    </div>
</div>

{{-- AJAX Loading --}}
<div id="ajax-loading">
    <div class="spinner-border text-warning" role="status"></div>
    <p class="mt-2 text-muted">Finding food spots...</p>
</div>

{{-- Results --}}
<div id="spots-results">
    @if($spots->isEmpty())
        <div class="alert alert-info text-center py-4">
            <i class="bi bi-emoji-frown fs-2 d-block mb-2"></i>
            No food spots found. Try a different search!
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($spots as $spot)
                <div class="col">
                    <div class="card spot-card h-100">
                        @if($spot->photos->first())
                            <img src="{{ asset('storage/'.$spot->photos->first()->path) }}" class="card-img-top">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light" style="height:190px;">
                                <i class="bi bi-image text-muted fs-1"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $spot->name }}</h5>
                            <p class="text-muted small mb-1"><i class="bi bi-geo-alt-fill text-danger"></i> {{ $spot->area }}</p>
                            <p class="text-muted small mb-2">
                                <i class="bi bi-star-fill text-warning"></i>
                                {{ number_format($spot->avg_rating, 1) }}
                                <span class="text-muted">({{ $spot->review_count }} reviews)</span>
                            </p>
                            <div class="d-flex gap-2 flex-wrap">
                                @if($spot->category)
                                    <span class="badge bg-warning text-dark">{{ $spot->category->name }}</span>
                                @endif
                                <span class="badge badge-{{ $spot->price_range }}">{{ ucfirst($spot->price_range) }}</span>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 pb-3">
                            <a href="{{ route('spots.show', $spot->id) }}" class="btn btn-outline-cp w-100">
                                View Details <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection

@section('scripts')
<script>
    // AJAX Search — async/await with Fetch API
    console.log('1. CravePath AJAX search initializing...');

    setTimeout(function() {
        console.log('4. setTimeout: search module ready');
    }, 0);

    Promise.resolve().then(function() {
        console.log('3. Promise microtask: event listeners attached');
    });

    console.log('2. Setting up search button listener...');

    document.getElementById('ajax-search-btn').addEventListener('click', async function() {
        const search      = document.getElementById('search').value;
        const area        = document.getElementById('area').value;
        const category_id = document.getElementById('category_id').value;
        const price_range = document.getElementById('price_range').value;

        // Show loading
        document.getElementById('ajax-loading').style.display = 'block';
        document.getElementById('spots-results').style.display = 'none';

        try {
            const url = new URL('{{ route("spots.ajax") }}');
            if (search)      url.searchParams.append('search', search);
            if (area)        url.searchParams.append('area', area);
            if (category_id) url.searchParams.append('category_id', category_id);
            if (price_range) url.searchParams.append('price_range', price_range);

            const response = await fetch(url, {
                headers: { 'Accept': 'application/json' }
            });

            const spots = await response.json();

            document.getElementById('ajax-loading').style.display = 'none';
            document.getElementById('spots-results').style.display = 'block';

            if (spots.length === 0) {
                document.getElementById('spots-results').innerHTML = `
                    <div class="alert alert-info text-center py-4">
                        <i class="bi bi-emoji-frown fs-2 d-block mb-2"></i>
                        No food spots found. Try a different search!
                    </div>`;
                return;
            }

            let html = '<div class="row row-cols-1 row-cols-md-3 g-4">';
            spots.forEach(spot => {
                const photo = spot.photo
                    ? `<img src="${spot.photo}" class="card-img-top" style="height:190px;object-fit:cover;">`
                    : `<div class="d-flex align-items-center justify-content-center bg-light" style="height:190px;"><i class="bi bi-image text-muted fs-1"></i></div>`;

                const category = spot.category
                    ? `<span class="badge bg-warning text-dark">${spot.category}</span>`
                    : '';

                html += `
                <div class="col">
                    <div class="card spot-card h-100">
                        ${photo}
                        <div class="card-body">
                            <h5 class="card-title">${spot.name}</h5>
                            <p class="text-muted small mb-1"><i class="bi bi-geo-alt-fill text-danger"></i> ${spot.area}</p>
                            <p class="text-muted small mb-2">
                                <i class="bi bi-star-fill text-warning"></i>
                                ${spot.avg_rating}
                                <span class="text-muted">(${spot.review_count} reviews)</span>
                            </p>
                            <div class="d-flex gap-2 flex-wrap">
                                ${category}
                                <span class="badge badge-${spot.price_range.toLowerCase()}">${spot.price_range}</span>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 pb-3">
                            <a href="${spot.url}" class="btn btn-outline-cp w-100">
                                View Details <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>`;
            });
            html += '</div>';

            document.getElementById('spots-results').innerHTML = html;

        } catch (error) {
            document.getElementById('ajax-loading').style.display = 'none';
            document.getElementById('spots-results').style.display = 'block';
            document.getElementById('spots-results').innerHTML = `
                <div class="alert alert-danger">Search failed. Please try again.</div>`;
        }
    });
</script>
@endsection