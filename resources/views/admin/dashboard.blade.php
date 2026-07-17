@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<h4 class="mb-4">Admin Dashboard</h4>

<div class="row g-4">

    {{-- Category --}}
    <div class="col-md-4">
        <div class="card p-3">
            <h5>Add Category</h5>
            <form method="POST" action="{{ route('admin.categories.store') }}">
                @csrf
                <div class="mb-2">
                    <input type="text" name="name" class="form-control" placeholder="Category name" required>
                </div>
                <button type="submit" class="btn btn-warning w-100">Add</button>
            </form>

            <ul class="list-group mt-3">
                @foreach($categories as $category)
                    <li class="list-group-item">{{ $category->name }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Pending Spots --}}
    <div class="col-md-8">
        <div class="card p-3 mb-4">
            <h5>Pending Food Spots ({{ $pendingSpots->count() }})</h5>
            @if($pendingSpots->isEmpty())
                <p class="text-muted">No pending spots.</p>
            @else
                <table class="table table-bordered align-middle">
                    <thead class="table-warning">
                        <tr>
                            <th>Name</th>
                            <th>Seller</th>
                            <th>Area</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingSpots as $spot)
                            <tr>
                                <td>{{ $spot->name }}</td>
                                <td>{{ $spot->seller->name }}</td>
                                <td>{{ $spot->area }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.spots.approve', $spot->id) }}" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-success">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.spots.delete', $spot->id) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

       
        <div class="card p-3">
            <h5>Flagged Reviews ({{ $flaggedReviews->count() }})</h5>
            @if($flaggedReviews->isEmpty())
                <p class="text-muted">No flagged reviews.</p>
            @else
                @foreach($flaggedReviews as $review)
                    <div class="card mb-2 p-2">
                        <p class="mb-1">{{ $review->remarks }}</p>
                        <small class="text-muted">By: {{ $review->user->name }}</small>
                        <form method="POST" action="{{ route('admin.reviews.delete', $review->id) }}" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Remove Review</button>
                        </form>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

</div>
@endsection