@extends('layouts.app')

@section('title', 'Seller Dashboard')

@section('content')

<div class="page-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1"><i class="bi bi-shop"></i> My Food Spots</h2>
                <p class="mb-0 opacity-75">Manage your listings</p>
            </div>
            <a href="{{ route('seller.spots.create') }}" class="btn btn-light fw-600 rounded-pill">
                <i class="bi bi-plus-circle"></i> Add New Spot
            </a>
        </div>
    </div>
</div>

@if($spots->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-shop fs-1 text-muted d-block mb-3"></i>
        <h5 class="text-muted">No food spots yet</h5>
        <p class="text-muted">Start by adding your first food spot!</p>
        <a href="{{ route('seller.spots.create') }}" class="btn btn-primary-cp">
            <i class="bi bi-plus-circle"></i> Add Food Spot
        </a>
    </div>
@else
    <div class="card spot-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Area</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Rating</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($spots as $spot)
                        <tr>
                            <td class="fw-600">{{ $spot->name }}</td>
                            <td><i class="bi bi-geo-alt text-danger"></i> {{ $spot->area }}</td>
                            <td><span class="badge badge-{{ $spot->price_range }}">{{ ucfirst($spot->price_range) }}</span></td>
                            <td>
                                @if($spot->is_approved)
                                    <span class="badge bg-success rounded-pill">✓ Approved</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill">⏳ Pending</span>
                                @endif
                            </td>
                            <td>
                                <i class="bi bi-star-fill text-warning"></i>
                                {{ number_format($spot->avg_rating, 1) }}
                                <small class="text-muted">({{ $spot->review_count }})</small>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('spots.show', $spot->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('spots.show', $spot->id) }}#reviews" class="btn btn-sm btn-outline-info rounded-pill" title="View reviews">
                                        <i class="bi bi-chat-dots"></i>
                                    </a>
                                    <a href="{{ route('seller.spots.edit', $spot->id) }}" class="btn btn-sm btn-outline-warning rounded-pill">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('seller.spots.destroy', $spot->id) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Delete?')">
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
    </div>
@endif

@endsection