@extends('layouts.app')

@section('title', 'Seller Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>My Food Spots</h4>
    <a href="{{ route('seller.spots.create') }}" class="btn btn-warning">+ Add New Spot</a>
</div>

@if($spots->isEmpty())
    <div class="alert alert-info">You haven't added any food spots yet.</div>
@else
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-warning">
                <tr>
                    <th>Name</th>
                    <th>Area</th>
                    <th>Price Range</th>
                    <th>Status</th>
                    <th>Rating</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($spots as $spot)
                    <tr>
                        <td>{{ $spot->name }}</td>
                        <td>{{ $spot->area }}</td>
                        <td>{{ ucfirst($spot->price_range) }}</td>
                        <td>
                            @if($spot->is_approved)
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-secondary">Pending</span>
                            @endif
                        </td>
                        <td>{{ number_format($spot->avg_rating, 1) }} ⭐ ({{ $spot->review_count }})</td>
                        <td>
                            <a href="{{ route('spots.show', $spot->id) }}" class="btn btn-sm btn-outline-secondary">View</a>
                            <a href="{{ route('seller.spots.edit', $spot->id) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                            <form method="POST" action="{{ route('seller.spots.destroy', $spot->id) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this spot?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection