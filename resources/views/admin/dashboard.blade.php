@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<div class="page-header">
    <div class="container">
        <h2 class="mb-1"><i class="bi bi-shield-check"></i> Admin Dashboard</h2>
        <p class="mb-0 opacity-75">Manage food spots, reviews and categories</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card spot-card text-center p-3">
            <div class="display-6 text-warning">{{ $pendingSpots->count() }}</div>
            <div class="text-muted small">Pending Spots</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card spot-card text-center p-3">
            <div class="display-6 text-danger">{{ $flaggedReviews->count() }}</div>
            <div class="text-muted small">Flagged Reviews</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card spot-card text-center p-3">
            <div class="display-6 text-success">{{ $categories->count() }}</div>
            <div class="text-muted small">Categories</div>
        </div>
    </div>
</div>

<div class="row g-4">

    {{-- Categories --}}
    <div class="col-md-4">
        <div class="card spot-card p-4">
            <h5 class="fw-700 mb-3"><i class="bi bi-tags text-warning"></i> Categories</h5>
            <form method="POST" action="{{ route('admin.categories.store') }}" class="mb-3">
                @csrf
                <div class="input-group">
                    <input type="text" name="name" class="form-control" placeholder="New category..." required>
                    <button type="submit" class="btn btn-primary-cp">Add</button>
                </div>
            </form>
            <ul class="list-group list-group-flush">
                @forelse($categories as $category)
                    <li class="list-group-item px-0 border-0 py-2">
                        <i class="bi bi-tag text-warning me-2"></i>{{ $category->name }}
                    </li>
                @empty
                    <li class="list-group-item px-0 border-0 py-2 text-muted">No categories yet.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card spot-card p-4">
            <h5 class="fw-700 mb-3"><i class="bi bi-clock-history text-warning"></i> Pending Spots</h5>
            @if($pendingSpots->isEmpty())
                <div class="text-center text-muted py-3">No pending spots right now.</div>
            @else
                @foreach($pendingSpots as $spot)
                    <div class="border rounded-3 p-3 bg-light mb-3">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <h6 class="fw-700 mb-1">{{ $spot->name }}</h6>
                                <p class="mb-1 text-muted small">Seller: {{ $spot->seller->name }}</p>
                                <p class="mb-1 text-muted small"><i class="bi bi-geo-alt text-danger"></i> {{ $spot->area }}</p>
                                @if($spot->address)
                                    <p class="mb-1 text-muted small"><i class="bi bi-signpost"></i> {{ $spot->address }}</p>
                                @endif
                                @if($spot->contact_number)
                                    <p class="mb-1 text-muted small"><i class="bi bi-telephone"></i> {{ $spot->contact_number }}</p>
                                @endif
                            </div>
                            <span class="badge bg-warning text-dark">Awaiting review</span>
                        </div>
                        <div class="mt-3 d-flex flex-wrap gap-2">
                            <a href="{{ route('admin.spots.detail', $spot->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill admin-detail-btn" data-id="{{ $spot->id }}">View Details</a>
                            <form method="POST" action="{{ route('admin.spots.approve', $spot->id) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-success rounded-pill">
                                    <i class="bi bi-check"></i> Approve
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.spots.delete', $spot->id) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger rounded-pill" onclick="return confirm('Remove this request from the public listings?')">
                                    <i class="bi bi-trash"></i> Remove Request
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

</div>

<div class="row g-4 mt-3">
    <div class="col-12">
        <div class="card spot-card p-4">
            <h5 class="fw-700 mb-3"><i class="bi bi-gear-fill text-warning"></i> Manage All Spots</h5>
            @if($allSpots->isEmpty())
                <div class="text-center text-muted py-3">No spots available yet.</div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Seller</th>
                                <th>Area</th>
                                <th>Status</th>
                                <th>Reviews</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allSpots as $spot)
                                <tr>
                                    <td class="fw-600">{{ $spot->name }}</td>
                                    <td>{{ $spot->seller->name }}</td>
                                    <td><i class="bi bi-geo-alt text-danger"></i> {{ $spot->area }}</td>
                                    <td>
                                        @if($spot->is_approved)
                                            <span class="badge bg-success rounded-pill">Approved</span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $spot->review_count }}</td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            <a href="{{ route('admin.spots.detail', $spot->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill admin-detail-btn" data-id="{{ $spot->id }}">Details</a>
                                            <form method="POST" action="{{ route('admin.spots.delete', $spot->id) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger rounded-pill" onclick="return confirm('Delete this spot?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

        {{-- Flagged Reviews --}}
        <div class="card spot-card p-4">
            <h5 class="fw-700 mb-3"><i class="bi bi-flag text-danger"></i> Flagged Reviews</h5>
            @if($flaggedReviews->isEmpty())
                <div class="text-center text-muted py-3">
                    <i class="bi bi-shield-check fs-2 d-block mb-2 text-success"></i>
                    No flagged reviews!
                </div>
            @else
                @foreach($flaggedReviews as $review)
                    <div class="card border-0 bg-light rounded-3 mb-3 p-3">
                        <p class="mb-1">{{ $review->remarks }}</p>
                        <small class="text-muted mb-2 d-block">By: {{ $review->user->name }}</small>
                        <form method="POST" action="{{ route('admin.reviews.delete', $review->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger rounded-pill">
                                <i class="bi bi-trash"></i> Remove Review
                            </button>
                        </form>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // create modal container
        let container = document.createElement('div');
        container.innerHTML = `
            <div class="modal fade" id="spotDetailModal" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">Loading...</div>
                </div>
            </div>`;
        document.body.appendChild(container);

        const modalEl = document.getElementById('spotDetailModal');
        const bsModal = new bootstrap.Modal(modalEl);

        document.querySelectorAll('.admin-detail-btn').forEach(btn => {
            btn.addEventListener('click', async function (e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                try {
                    const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                    const html = await res.text();
                    modalEl.querySelector('.modal-content').innerHTML = html;
                    bsModal.show();
                } catch (err) {
                    alert('Failed to load details');
                }
            });
        });
    });
</script>
@endsection