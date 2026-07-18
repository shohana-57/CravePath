@extends('layouts.app')

@section('title', 'Add Food Spot')

@section('content')

<div class="page-header">
    <div class="container">
        <h2 class="mb-1"><i class="bi bi-plus-circle"></i> Add New Food Spot</h2>
        <p class="mb-0 opacity-75">Submit your food spot for admin approval</p>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card spot-card p-4">
            <form method="POST" action="{{ route('seller.spots.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-600">Spot Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                        placeholder="e.g. Rahman's Fuchka Corner" required>
                    @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-600">Description</label>
                    <textarea name="description" class="form-control" rows="3"
                        placeholder="Tell customers what makes your spot special...">{{ old('description') }}</textarea>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-600">Area <span class="text-danger">*</span></label>
                        <input type="text" name="area" class="form-control" value="{{ old('area') }}"
                            placeholder="e.g. Khulna Sadar, Dhanmondi" required>
                        @error('area')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600">Full Address</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address') }}"
                            placeholder="e.g. House 12, Road 5, Khulna">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-600">Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600">Price Range <span class="text-danger">*</span></label>
                        <select name="price_range" class="form-select" required>
                            <option value="budget">💚 Budget (under 100 BDT)</option>
                            <option value="mid">💛 Mid (100–300 BDT)</option>
                            <option value="premium">❤️ Premium (300+ BDT)</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-600">Contact Number</label>
                        <input type="text" name="contact_number" class="form-control" placeholder="e.g. +88017...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600">Contact Email</label>
                        <input type="email" name="contact_email" class="form-control" placeholder="shop@example.com">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-600">Google Maps Link</label>
                        <input type="url" name="map_link" class="form-control" placeholder="https://maps.google.com/...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600">Opening Hours</label>
                        <input type="text" name="opening_hours" class="form-control" placeholder="10 AM – 10 PM">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-600">Menu / Promo Video URL</label>
                    <input type="url" name="video_url" class="form-control" placeholder="https://youtube.com/watch?v=...">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-600">Photos (you can select multiple)</label>
                    <input type="file" name="photos[]" class="form-control" accept="image/*" multiple>
                    <small class="text-muted">Upload photos of your food spot, food items etc. Max 2MB each.</small>
                </div>

                <button type="submit" class="btn btn-primary-cp w-100">
                    <i class="bi bi-send"></i> Submit for Approval
                </button>
            </form>
        </div>
    </div>
</div>

@endsection