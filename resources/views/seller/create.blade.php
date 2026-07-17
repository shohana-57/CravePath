@extends('layouts.app')

@section('title', 'Add Food Spot')

@section('content')
<div class="card p-4" style="max-width:600px; margin:auto;">
    <h4 class="mb-4">Add New Food Spot</h4>

    <form method="POST" action="{{ route('seller.spots.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Spot Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Area</label>
            <input type="text" name="area" class="form-control" value="{{ old('area') }}" placeholder="e.g. Dhanmondi, Khulna Sadar" required>
            @error('area')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Full Address (optional)</label>
            <input type="text" name="address" class="form-control" value="{{ old('address') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Price Range</label>
            <select name="price_range" class="form-select" required>
                <option value="budget">Budget (under 100 BDT)</option>
                <option value="mid">Mid (100–300 BDT)</option>
                <option value="premium">Premium (300+ BDT)</option>
            </select>
        </div>

        <button type="submit" class="btn btn-warning w-100">Submit for Approval</button>
    </form>
</div>
@endsection