@extends('layouts.app')

@section('title', 'Edit - {{ $foodSpot->name }}')

@section('content')

<div class="page-header">
    <div class="container">
        <h2 class="mb-1"><i class="bi bi-pencil-square"></i> Edit: {{ $foodSpot->name }}</h2>
        <p class="mb-0 opacity-75">
            Status:
            @if($foodSpot->is_approved)
                <span class="badge bg-success">✓ Approved</span>
            @else
                <span class="badge bg-warning text-dark">⏳ Pending Approval</span>
            @endif
        </p>
    </div>
</div>

<div class="row g-4">

    {{-- Left: Edit Form --}}
    <div class="col-md-6">
        <div class="card spot-card p-4 mb-4">
            <h5 class="fw-700 mb-3"><i class="bi bi-info-circle text-warning"></i> Spot Details</h5>
            <form method="POST" action="{{ route('seller.spots.update', $foodSpot->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-600">Spot Name</label>
                    <input type="text" name="name" class="form-control"
                        value="{{ old('name', $foodSpot->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-600">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $foodSpot->description) }}</textarea>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-600">Area</label>
                        <input type="text" name="area" class="form-control"
                            value="{{ old('area', $foodSpot->area) }}" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-600">Address</label>
                        <input type="text" name="address" class="form-control"
                            value="{{ old('address', $foodSpot->address) }}">
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-600">Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">None</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $foodSpot->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-600">Price Range</label>
                        <select name="price_range" class="form-select" required>
                            <option value="budget" {{ $foodSpot->price_range == 'budget' ? 'selected' : '' }}>💚 Budget</option>
                            <option value="mid" {{ $foodSpot->price_range == 'mid' ? 'selected' : '' }}>💛 Mid</option>
                            <option value="premium" {{ $foodSpot->price_range == 'premium' ? 'selected' : '' }}>❤️ Premium</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary-cp w-100">
                    <i class="bi bi-check-circle"></i> Update Spot
                </button>
            </form>
        </div>

        {{-- Add Menu Item --}}
        <div class="card spot-card p-4">
            <h5 class="fw-700 mb-3"><i class="bi bi-menu-button-wide text-warning"></i> Menu Items</h5>

            <form method="POST" action="{{ route('seller.menu.store', $foodSpot->id) }}" class="mb-3">
                @csrf
                <div class="row g-2">
                    <div class="col-7">
                        <input type="text" name="name" class="form-control" placeholder="Item name" required>
                    </div>
                    <div class="col-3">
                        <input type="number" name="price" class="form-control" placeholder="Price" step="0.01" required>
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-primary-cp w-100">
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                </div>
            </form>

            @if($foodSpot->menuItems->count())
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead>
                            <tr><th>Item</th><th>Price</th><th></th></tr>
                        </thead>
                        <tbody>
                            @foreach($foodSpot->menuItems as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>৳ {{ number_format($item->price, 2) }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('seller.menu.destroy', $item->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger rounded-pill">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted small text-center">No menu items yet.</p>
            @endif
        </div>
    </div>

    {{-- Right: Photos --}}
    <div class="col-md-6">
        <div class="card spot-card p-4">
            <h5 class="fw-700 mb-3"><i class="bi bi-images text-warning"></i> Photos</h5>

            <form method="POST" action="{{ route('seller.photos.store', $foodSpot->id) }}"
                enctype="multipart/form-data" class="mb-4">
                @csrf
                <div class="mb-2">
                    <input type="file" name="photo" class="form-control" accept="image/*" required>
                    <small class="text-muted">Max 2MB. JPG, PNG, GIF accepted.</small>
                </div>
                <button type="submit" class="btn btn-primary-cp w-100">
                    <i class="bi bi-cloud-upload"></i> Upload Photo
                </button>
            </form>

            @if($foodSpot->photos->count())
                <div class="row g-2">
                    @foreach($foodSpot->photos as $photo)
                        <div class="col-6 position-relative">
                            <img src="{{ asset('storage/'.$photo->path) }}"
                                class="img-fluid rounded"
                                style="height:130px; object-fit:cover; width:100%;">
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-muted py-4">
                    <i class="bi bi-image fs-2 d-block mb-2"></i>
                    No photos uploaded yet.
                </div>
            @endif
        </div>
    </div>
</div>

@endsection