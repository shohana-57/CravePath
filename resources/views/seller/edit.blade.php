@extends('layouts.app')

@section('title', 'Edit Food Spot')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card p-4 mb-4">
            <h4 class="mb-4">Edit Food Spot</h4>

            <form method="POST" action="{{ route('seller.spots.update', $foodSpot->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Spot Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $foodSpot->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $foodSpot->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Area</label>
                    <input type="text" name="area" class="form-control" value="{{ old('area', $foodSpot->area) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Full Address</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $foodSpot->address) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $foodSpot->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Price Range</label>
                    <select name="price_range" class="form-select" required>
                        <option value="budget" {{ $foodSpot->price_range == 'budget' ? 'selected' : '' }}>Budget</option>
                        <option value="mid" {{ $foodSpot->price_range == 'mid' ? 'selected' : '' }}>Mid</option>
                        <option value="premium" {{ $foodSpot->price_range == 'premium' ? 'selected' : '' }}>Premium</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-warning w-100">Update Spot</button>
            </form>
        </div>
    </div>

    <div class="col-md-6">
        {{-- Add Menu Item --}}
        <div class="card p-4 mb-4">
            <h5>Add Menu Item</h5>
            <form method="POST" action="{{ route('seller.menu.store', $foodSpot->id) }}">
                @csrf
                <div class="mb-2">
                    <input type="text" name="name" class="form-control" placeholder="Item name" required>
                </div>
                <div class="mb-2">
                    <input type="number" name="price" class="form-control" placeholder="Price (BDT)" step="0.01" required>
                </div>
                <button type="submit" class="btn btn-warning w-100">Add Item</button>
            </form>

            @if($foodSpot->menuItems->count())
                <ul class="list-group mt-3">
                    @foreach($foodSpot->menuItems as $item)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $item->name }}</span>
                            <span>{{ number_format($item->price, 2) }} BDT</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- Upload Photo --}}
        <div class="card p-4">
            <h5>Upload Photo</h5>
            <form method="POST" action="{{ route('seller.photos.store', $foodSpot->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-2">
                    <input type="file" name="photo" class="form-control" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-warning w-100">Upload</button>
            </form>
        </div>
    </div>
</div>
@endsection